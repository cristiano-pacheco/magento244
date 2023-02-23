<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Repository\Command;

use RunAsRoot\MessageQueueRetry\Exception\MessageCouldNotBeCreatedException;
use RunAsRoot\MessageQueueRetry\Model\Message;
use RunAsRoot\MessageQueueRetry\Model\ResourceModel\Message as ResourceModel;

class CreateMessageCommand
{
    public function __construct(private ResourceModel $resourceModel)
    {
    }

    /**
     * @throws MessageCouldNotBeCreatedException
     */
    public function execute(Message $model): Message
    {
        try {
            $this->resourceModel->save($model);
        } catch (\Exception $e) {
            throw new MessageCouldNotBeCreatedException(
                __('Could not save message: %1', $e->getMessage()), $e
            );
        }

        return $model;
    }
}
