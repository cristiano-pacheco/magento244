<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Repository\Command;

use RunAsRoot\MessageQueueRetry\Model\ResourceModel\FailedQueue as ResourceModel;
use RunAsRoot\MessageQueueRetry\Repository\Query\FindFailedQueueById;
use RunAsRoot\MessageQueueRetry\Exception\FailedQueueNotBeDeletedException;

class DeleteFailedQueueByIdCommand
{
    public function __construct(
        private ResourceModel $resourceModel,
        private FindFailedQueueById $findFailedQueueById
    ) {
    }

    /**
     * @throws FailedQueueNotBeDeletedException
     */
    public function execute(int $entityId): void
    {
        try {
            $model = $this->findFailedQueueById->execute($entityId);
            $this->resourceModel->delete($model);
        } catch (\Exception $e) {
            throw new FailedQueueNotBeDeletedException(
                __('Failed queue with id %1 could not deleted', $entityId), $e
            );
        }
    }
}
