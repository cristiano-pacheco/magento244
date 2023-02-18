<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Repository\Command;

use RunAsRoot\MessageQueueRetry\Model\ResourceModel\FailedQueue as ResourceModel;
use RunAsRoot\MessageQueueRetry\Repository\Query\FindFailedQueueById;

class DeleteFailedQueueCommand
{
    public function __construct(
        private ResourceModel $resourceModel,
        private FindFailedQueueById $findFailedQueueById
    ) {
    }

    /**
     * @throws FailedQueueCouldNotBeDeletedException
     */
    public function execute(int $entityId): void
    {
        try {
            $model = $this->findFailedQueueById->execute($entityId);
            $this->resourceModel->delete($model);
        } catch (\Exception $e) {
            throw new FailedQueueCouldNotBeDeletedException(
                __('Failed queue with id %1 could not deleted', $e->getMessage()), $e
            );
        }
    }
}
