<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Repository\Command;

use RunAsRoot\MessageQueueRetry\Model\Message;
use RunAsRoot\MessageQueueRetry\Model\ResourceModel\Message as ResourceModel;
use RunAsRoot\MessageQueueRetry\Repository\Query\FindMessageByIdQuery;
use RunAsRoot\MessageQueueRetry\Exception\MessageCouldNotBeDeletedException;

class DeleteMessageCommand
{
    public function __construct(private ResourceModel $resourceModel)
    {
    }

    /**
     * @throws MessageCouldNotBeDeletedException
     */
    public function execute(Message $model): void
    {
        try {
            $this->resourceModel->delete($model);
        } catch (\Exception $e) {
            throw new MessageCouldNotBeDeletedException(
                __('Message with id %1 could not deleted', $model->getId()), $e
            );
        }
    }
}
