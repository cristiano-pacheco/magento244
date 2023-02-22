<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\System\Config;

use JsonException;
use Magento\Framework\App\Config\ScopeConfigInterface;

class MessageQueueRetryConfig
{
    public const MAIN_TOPIC_NAME = 'main_topic_name';
    public const DELAY_TOPIC_NAME = 'delay_topic_name';
    public const RETRY_LIMIT = 'retry_limit';
    private const XML_PATH_DELAY_QUEUES = 'message_queue_retry/general/delay_queues';
    private const XML_PATH_ENABLE_DELAY_QUEUE = 'message_queue_retry/general/enable_delay_queue';

    public function __construct(private ScopeConfigInterface $scopeConfig)
    {
    }

    public function isDelayQueueEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE_DELAY_QUEUE);
    }

    /**
     * @throws JsonException
     */
    public function getDelayQueues(): array
    {
        $configValue = $this->scopeConfig->getValue(self::XML_PATH_DELAY_QUEUES);

        if ($configValue) {
            return json_decode($configValue, true, 512, JSON_THROW_ON_ERROR);
        }

        return [];
    }
}
