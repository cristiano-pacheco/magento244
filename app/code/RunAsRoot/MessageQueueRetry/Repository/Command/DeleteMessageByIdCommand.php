<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Repository\Command;

use RunAsRoot\MessageQueueRetry\Model\ResourceModel\Message as ResourceModel;
use RunAsRoot\MessageQueueRetry\Repository\Query\FindMessageById;
use RunAsRoot\MessageQueueRetry\Exception\MessageCouldNotBeDeletedException;

class DeleteMessageByIdCommand
{
    public function __construct(
        private ResourceModel $resourceModel,
        private FindMessageById $findFailedQueueById
    ) {
    }

    /**
     * @throws MessageCouldNotBeDeletedException
     */
    public function execute(int $entityId): void
    {
        try {
            $model = $this->findFailedQueueById->execute($entityId);
            $this->resourceModel->delete($model);
        } catch (\Exception $e) {
            throw new MessageCouldNotBeDeletedException(
                __('Message with id %1 could not deleted', $entityId), $e
            );
        }
    }
}
