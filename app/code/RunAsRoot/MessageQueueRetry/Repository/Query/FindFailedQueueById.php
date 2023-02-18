<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Repository\Query;

use RunAsRoot\MessageQueueRetry\Model\FailedQueue;
use RunAsRoot\MessageQueueRetry\Model\FailedQueueFactory as ModelFactory;
use RunAsRoot\MessageQueueRetry\Model\ResourceModel\FailedQueue as ResourceModel;

class FindFailedQueueById
{
    public function __construct(
        private ResourceModel $resourceModel,
        private ModelFactory $modelFactory
    ) {
    }

    /**
     * @throws FailedQueueNotFoundException
     */
    public function execute(int $entityId): FailedQueue
    {
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $entityId);

        if (!$model->getId()) {
            throw new FailedQueueNotFoundException(__('Failed queue with id "%1" could not be found.', $entityId));
        }

        return $model;
    }
}
