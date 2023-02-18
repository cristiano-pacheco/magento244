<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Model;

use Magento\Framework\Model\AbstractModel;
use RunAsRoot\MessageQueueRetry\Model\ResourceModel\FailedQueue as ResourceModel;

class FailedQueue extends AbstractModel implements \RunAsRoot\MessageQueueRetry\Api\Data\FailedQueueInterface
{
    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }

    public function getTopicName(): string
    {
        return $this->getData(self::TOPIC_NAME);
    }

    public function setTopicName(string $value): void
    {
        $this->setData(self::TOPIC_NAME, $value);
    }

    public function getMessageBody(): string
    {
        return $this->getData(self::MESSAGE_BODY);
    }

    public function setMessageBody(string $value): void
    {
        $this->setData(self::MESSAGE_BODY, $value);
    }

    public function getResourceId(): string
    {
        return $this->getData(self::RESOURCE_ID);
    }

    public function setResourceId(string $value): void
    {
        $this->setData(self::RESOURCE_ID, $value);
    }

    public function getTotalRetries(): int
    {
        return $this->getData(self::TOTAL_RETRIES);
    }

    public function setTotalRetries(int $value): void
    {
        $this->setData(self::TOTAL_RETRIES, $value);
    }

    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(string $value): void
    {
        $this->setData(self::CREATED_AT, $value);
    }
}
