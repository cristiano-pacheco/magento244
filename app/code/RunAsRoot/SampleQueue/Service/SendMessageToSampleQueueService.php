<?php declare(strict_types=1);

namespace RunAsRoot\SampleQueue\Service;

use RunAsRoot\SampleQueue\Queue\Publisher\SampleQueuePublisher;

class SendMessageToSampleQueueService
{
    public function __construct(private SampleQueuePublisher $sampleQueuePublisher)
    {
    }

    public function execute(): void
    {
        $data = $this->getMessage();
        $this->sampleQueuePublisher->execute($data);
    }

    private function getMessage(): string
    {
        return 'Oh Yeah!';
        $channel = curl_init('https://api.chucknorris.io/jokes/random');

        curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($channel);

        $result = json_decode($response, true);

        curl_close($channel);

        return $result['value'] ?? 'Oh Yeah!';
    }
}
