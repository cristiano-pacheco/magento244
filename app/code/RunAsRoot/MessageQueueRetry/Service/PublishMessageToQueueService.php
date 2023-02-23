<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Service;

use RunAsRoot\MessageQueueRetry\Exception\MessageNotFoundException;
use RunAsRoot\MessageQueueRetry\Repository\MessageRepository;
use RunAsRoot\MessageQueueRetry\Exception\MessageCouldNotBeDeletedException;
use RunAsRoot\MessageQueueRetry\Exception\InvalidMessageQueueConnectionTypeException;
use RunAsRoot\MessageQueueRetry\Exception\InvalidPublisherConfigurationException;
use RunAsRoot\MessageQueueRetry\Serializer\MessageSerializer;
use RunAsRoot\MessageQueueRetry\Queue\Publisher;
use RunAsRoot\MessageQueueRetry\Model\Message;

class PublishMessageToQueueService
{
    public function __construct(
        private Publisher $publisher,
        private MessageRepository $messageRepository
    ) {
    }

    /**
     * @throws MessageCouldNotBeDeletedException
     * @throws MessageNotFoundException
     * @throws InvalidMessageQueueConnectionTypeException
     * @throws InvalidPublisherConfigurationException
     */
    public function executeById(int $messageId): void
    {
        $message = $this->messageRepository->findById($messageId);
        $this->publisher->publish($message->getTopicName(), $message->getMessageBody());
        $this->messageRepository->delete($message);
    }

    /**
     * @throws MessageCouldNotBeDeletedException
     * @throws MessageNotFoundException
     * @throws InvalidMessageQueueConnectionTypeException
     * @throws InvalidPublisherConfigurationException
     */
    public function executeByMessage(Message $message): void
    {
        $this->publisher->publish($failedQueue->getTopicName(), $failedQueue->getMessageBody());
        $this->messageRepository->delete($message);
    }
}
