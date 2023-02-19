<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Service;

use Magento\Framework\MessageQueue\PublisherInterface;
use RunAsRoot\MessageQueueRetry\Exception\FailedQueueNotFoundException;
use RunAsRoot\MessageQueueRetry\Repository\FailedQueueRepository;
use RunAsRoot\MessageQueueRetry\Exception\FailedQueueNotBeDeletedException;

class PublishMessageToQueueService
{
    public function __construct(
        private PublisherInterface $publisher,
        private FailedQueueRepository $failedQueueRepository
    ) {
    }

    /**
     * @throws FailedQueueNotFoundException
     * @throws FailedQueueNotBeDeletedException
     */
    public function execute(int $messageId): void
    {
        $message = $this->failedQueueRepository->findById($messageId);
        $this->publisher->publish($message->getTopicName(), $message->getMessageBody());
        $this->failedQueueRepository->deleteById($messageId);
    }
}
