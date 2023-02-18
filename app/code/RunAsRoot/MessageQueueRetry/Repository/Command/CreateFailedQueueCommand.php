<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Repository\Command;

use RunAsRoot\MessageQueueRetry\Exception\FailedQueueCouldNotBeCreatedException;
use RunAsRoot\MessageQueueRetry\Model\ResourceModel\FailedQueue as ResourceModel;
use RunAsRoot\MessageQueueRetry\Model\FailedQueue as FailedQueueModel;

class CreateFailedQueueCommand
{
    public function __construct(private ResourceModel $resourceModel)
    {
    }

    /**
     * @throws FailedQueueCouldNotBeCreatedException
     */
    public function execute(FailedQueueModel $model): FailedQueueModel
    {
        try {
            $this->resourceModel->save($model);
        } catch (\Exception $e) {
            throw new FailedQueueCouldNotBeCreatedException(
                __('Could not save failed queue: %1', $e->getMessage()), $e
            );
        }

        return $model;
    }
}
