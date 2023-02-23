<?php

declare(strict_types=1);

namespace RunAsRoot\SampleQueue\Queue\Consumer;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;

class SampleQueueConsumer
{
    public function execute(string $message): void
    {
        throw new LocalizedException(new Phrase('Oh no!'));
    }
}
