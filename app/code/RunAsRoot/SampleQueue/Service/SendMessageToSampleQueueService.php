<?php declare(strict_types=1);

namespace RunAsRoot\SampleQueue\Service;

use RunAsRoot\SampleQueue\Api\Data\ChuckNorrisJokeDataInterfaceFactory;
use RunAsRoot\SampleQueue\Queue\Publisher\SampleQueuePublisher;

class SendMessageToSampleQueueService
{
    public function __construct(
        private SampleQueuePublisher $sampleQueuePublisher,
        private ChuckNorrisJokeDataInterfaceFactory $chuckNorrisJokeDataFactory
    ) {
    }

    public function execute(): void
    {
        $data = $this->getMessage();
        $chuckNorrisJokeData = $this->chuckNorrisJokeDataFactory->create([
            'id' => $data['id'],
            'value' => $data['value'],
            'url' => $data['url'],
            'iconUrl' => $data['icon_url'],
            'createdAt' => $data['created_at'],
            'updatedAt' => $data['updated_at'],
        ]);
        $this->sampleQueuePublisher->execute($chuckNorrisJokeData);
    }

    private function getMessage(): array
    {
        $channel = curl_init('https://api.chucknorris.io/jokes/random');

        curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($channel);

        $result = json_decode($response, true);

        curl_close($channel);

        return $result ?? [];
    }
}
