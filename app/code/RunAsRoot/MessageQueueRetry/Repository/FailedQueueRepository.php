<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Repository;

use RunAsRoot\MessageQueueRetry\Exception\FailedQueueCouldNotBeCreatedException;
use RunAsRoot\MessageQueueRetry\Exception\FailedQueueNotBeDeletedException;
use RunAsRoot\MessageQueueRetry\Exception\FailedQueueNotFoundException;
use RunAsRoot\MessageQueueRetry\Model\FailedQueue;
use RunAsRoot\MessageQueueRetry\Model\FailedQueueFactory;
use RunAsRoot\MessageQueueRetry\Model\ResourceModel\FailedQueue\CollectionFactory;
use RunAsRoot\MessageQueueRetry\Repository\Command\CreateFailedQueueCommand;
use RunAsRoot\MessageQueueRetry\Repository\Command\DeleteFailedQueueCommand;
use RunAsRoot\MessageQueueRetry\Repository\Query\FindFailedQueueById;

class FailedQueueRepository
{
    public function __construct(
        private CreateFailedQueueCommand $createFailedQueueCommand,
        private DeleteFailedQueueCommand $deleteFailedQueueCommand,
        private FindFailedQueueById $findFailedQueueById
    ) {
    }

    /**
     * @throws FailedQueueNotFoundException
     */
    public function findById(int $id): FailedQueue
    {
        return $this->findFailedQueueById->execute($id);
    }

    /**
     * @throws FailedQueueCouldNotBeCreatedException
     */
    public function create(FailedQueue $entity): FailedQueue
    {
        return $this->createFailedQueueCommand->execute($entity);
    }

    /**
     * @throws FailedQueueNotBeDeletedException
     */
    public function deleteById(int $id): void
    {
        $this->deleteFailedQueueCommand->execute($id);
    }
}
