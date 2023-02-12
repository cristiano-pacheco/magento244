<?php declare(strict_types=1);

namespace RunAsRoot\SampleQueue\Queue\Publisher;

use Magento\Framework\MessageQueue\PublisherInterface;

class SampleQueuePublisher
{
    public const TOPIC_NAME = 'run_as_root.sample.queue';

    public function __construct(private PublisherInterface $publisher)
    {
    }

    public function execute(string $data): void
    {
        $this->publisher->publish(self::TOPIC_NAME, $data);
    }
}