<?php declare(strict_types=1);

namespace RunAsRoot\SampleQueue\Queue\Publisher;

use Magento\Framework\MessageQueue\PublisherInterface;
use RunAsRoot\SampleQueue\Api\Data\ChuckNorrisJokeDataInterface;

class SampleQueuePublisher
{
    public const TOPIC_NAME = 'sample_topic';

    public function __construct(private PublisherInterface $publisher)
    {
    }

    public function execute(ChuckNorrisJokeDataInterface $data): void
    {
        $this->publisher->publish(self::TOPIC_NAME, $data);
    }
}
