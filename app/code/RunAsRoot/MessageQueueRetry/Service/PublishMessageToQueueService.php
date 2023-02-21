<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Service;

use RunAsRoot\MessageQueueRetry\Exception\FailedQueueNotFoundException;
use RunAsRoot\MessageQueueRetry\Repository\FailedQueueRepository;
use RunAsRoot\MessageQueueRetry\Exception\FailedQueueNotBeDeletedException;
use RunAsRoot\MessageQueueRetry\Exception\InvalidMessageQueueConnectionTypeException;
use RunAsRoot\MessageQueueRetry\Exception\InvalidPublisherConfigurationException;
use RunAsRoot\MessageQueueRetry\Serializer\MessageSerializer;
use RunAsRoot\MessageQueueRetry\Queue\Publisher;
use RunAsRoot\MessageQueueRetry\Model\FailedQueue;

class PublishMessageToQueueService
{
    public function __construct(
        private Publisher $publisher,
        private FailedQueueRepository $failedQueueRepository
    ) {
    }

    /**
     * @throws FailedQueueNotBeDeletedException
     * @throws FailedQueueNotFoundException
     * @throws InvalidMessageQueueConnectionTypeException
     * @throws InvalidPublisherConfigurationException
     */
    public function executeById(int $messageId): void
    {
        $failedQueue = $this->failedQueueRepository->findById($messageId);
        $this->publisher->publish($failedQueue->getTopicName(), $failedQueue->getMessageBody());
        $this->failedQueueRepository->delete($failedQueue);
    }

    /**
     * @throws FailedQueueNotBeDeletedException
     * @throws FailedQueueNotFoundException
     * @throws InvalidMessageQueueConnectionTypeException
     * @throws InvalidPublisherConfigurationException
     */
    public function executeByFailedQueue(FailedQueue $failedQueue): void
    {
        $this->publisher->publish($failedQueue->getTopicName(), $failedQueue->getMessageBody());
        $this->failedQueueRepository->delete($failedQueue);
    }
}
