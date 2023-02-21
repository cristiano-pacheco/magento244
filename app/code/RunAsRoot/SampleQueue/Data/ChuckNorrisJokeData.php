<?php declare(strict_types=1);

namespace RunAsRoot\SampleQueue\Data;

use RunAsRoot\SampleQueue\Api\Data\ChuckNorrisJokeDataInterface;

class ChuckNorrisJokeData implements ChuckNorrisJokeDataInterface
{
    public function __construct(
        private readonly string $id,
        private readonly string $value,
        private readonly string $url,
        private readonly string $iconUrl,
        private readonly string $createdAt,
        private readonly string $updatedAt
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getIconUrl(): string
    {
        return $this->iconUrl;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}
