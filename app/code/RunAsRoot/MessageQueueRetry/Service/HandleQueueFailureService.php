<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Service;

use Exception;
use Magento\Framework\Amqp\Queue;
use Magento\Framework\MessageQueue\Envelope;
use RunAsRoot\MessageQueueRetry\Model\FailedQueueFactory;
use RunAsRoot\MessageQueueRetry\Repository\FailedQueueRepository;
use RunAsRoot\MessageQueueRetry\System\Config\MessageQueueRetryConfig;
use JsonException;
use Magento\Framework\MessageQueue\ConnectionLostException;
use RunAsRoot\MessageQueueRetry\Exception\FailedQueueCouldNotBeCreatedException;

class HandleQueueFailureService
{
    public function __construct(
        private MessageQueueRetryConfig $messageQueueRetryConfig,
        private FailedQueueFactory $failedQueueFactory,
        private FailedQueueRepository $failedQueueRepository
    ) {
    }

    /**
     * @throws JsonException
     * @throws ConnectionLostException
     * @throws FailedQueueCouldNotBeCreatedException
     */
    public function execute(Queue $queue, Envelope $message, Exception $exception): void
    {
        if (!$this->messageQueueRetryConfig->isDelayQueueEnabled()) {
            $this->reject($queue, $message, $exception);
            return;
        }

        $messageProperties = $message->getProperties();
        $applicationHeaders = $messageProperties['application_headers'] ?? null;

        // If there are no application headers, then it is the first time the message has been processed.
        if (!$applicationHeaders) {
            $this->reject($queue, $message, $exception);
            return;
        }

        $totalRetries = 1;
        if (isset($applicationHeaders->getNativeData()['x-death'][0]['count'])) {
            // +1 is added because the first time the message is processed, it is not counted as a retry.
            $totalRetries = $applicationHeaders->getNativeData()['x-death'][0]['count'] + 1;
        }

        $topicName = $message->getProperties()['topic_name'] ?? null;

        if (!$topicName) {
            $this->executeDefaultBehavior($queue, $message, $exception);
            return;
        }

        $delayQueueConfiguration = $this->messageQueueRetryConfig->getDelayQueues();
        $queueConfiguration = $delayQueueConfiguration[$topicName] ?? null;

        if (!$queueConfiguration) {
            $this->reject($queue, $message, $exception);
            return;
        }

        $retryLimit = $queueConfiguration[MessageQueueRetryConfig::RETRY_LIMIT] ?? 0;

        if ($totalRetries >= $retryLimit) {
            $failedQueueMessage = $this->failedQueueFactory->create();
            $failedQueueMessage->setTopicName($topicName);
            $failedQueueMessage->setMessageBody($message->getBody());
            $failedQueueMessage->setFailureDescription($exception->getMessage());
            $failedQueueMessage->setTotalRetries($totalRetries);
            $this->failedQueueRepository->create($failedQueueMessage);
            $queue->acknowledge($message);
        } else {
            $this->reject($queue, $message, $exception);
        }
    }

    private function reject(Queue $queue, Envelope $message, Exception $exception): void
    {
        $queue->reject($message, false, $exception->getMessage());
    }
}
