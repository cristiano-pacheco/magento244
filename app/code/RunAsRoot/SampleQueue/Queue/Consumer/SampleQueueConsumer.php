<?php declare(strict_types=1);

namespace RunAsRoot\SampleQueue\Queue\Consumer;

class SampleQueueConsumer
{
    public function execute(string $message): void
    {
        echo $message.PHP_EOL;

        throw new \Exception('Oh no!');
    }
}
