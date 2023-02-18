<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Model\ResourceModel\FailedQueue;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use RunAsRoot\MessageQueueRetry\Model\FailedQueue as Model;
use RunAsRoot\MessageQueueRetry\Model\ResourceModel\FailedQueue as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
