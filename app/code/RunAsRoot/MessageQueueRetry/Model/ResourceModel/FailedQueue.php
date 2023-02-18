<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use RunAsRoot\MessageQueueRetry\Api\Data\FailedQueueInterface;

class FailedQueue extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init(FailedQueueInterface::TABLE_NAME, FailedQueueInterface::ENTITY_ID);
    }
}
