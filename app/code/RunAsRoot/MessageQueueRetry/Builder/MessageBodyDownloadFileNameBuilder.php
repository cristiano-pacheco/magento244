<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Builder;

use RunAsRoot\MessageQueueRetry\Model\FailedQueue;

class MessageBodyDownloadFileNameBuilder
{
    public function build(FailedQueue $failedQueueModel): string
    {
        return $failedQueueModel->getTopicName() . '_' . $failedQueueModel->getId() . '.json';
    }
}
