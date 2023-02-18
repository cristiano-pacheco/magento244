<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Validator;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use RunAsRoot\MessageQueueRetry\System\Config\ConfigFieldNames;

class QueueConfigurationValidator
{
    /**
     * @throws LocalizedException
     */
    public function validate(array $configValues): bool
    {
        $topicNames = [];
        foreach ($configValues as $configValue) {
            if (!isset($configValue[ConfigFieldNames::DELAY_TOPIC_NAME])) {
                continue;
            }

            if (in_array($configValue[ConfigFieldNames::DELAY_TOPIC_NAME], $topicNames)) {
                throw new LocalizedException(
                    new Phrase(
                        'Delay topic name "%1" is already used.', [$configValue[ConfigFieldNames::DELAY_TOPIC_NAME]]
                    )
                );
            }

            $topicNames[] = $configValue[ConfigFieldNames::DELAY_TOPIC_NAME];
        }

        return true;
    }
}
