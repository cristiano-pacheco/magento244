<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Service;

use RunAsRoot\MessageQueueRetry\Exception\FailedQueueNotFoundException;
use RunAsRoot\MessageQueueRetry\Repository\FailedQueueRepository;
use RunAsRoot\MessageQueueRetry\Exception\FailedQueueNotBeDeletedException;
use RunAsRoot\MessageQueueRetry\Exception\InvalidMessageQueueConnectionTypeException;
use RunAsRoot\MessageQueueRetry\Exception\InvalidPublisherConfigurationException;
use RunAsRoot\MessageQueueRetry\Serializer\MessageSerializer;
use RunAsRoot\MessageQueueRetry\Queue\Publisher;

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
    public function execute(int $messageId): void
    {
        $message = $this->failedQueueRepository->findById($messageId);
        $this->publisher->publish($message->getTopicName(), $message->getMessageBody());
        $this->failedQueueRepository->deleteById($messageId);
    }
}
