<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\System\Config;

use JsonException;

class MessageQueueRetryConfig
{
    public const DELAY_TOPIC_NAME = 'delay_queues';
    public const RETRY_LIMIT = 'retry_limit';
    private const XML_PATH_DELAY_QUEUES = 'message_queue_retry/general/delay_queues';

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
