<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Repository;

use RunAsRoot\MessageQueueRetry\Exception\FailedQueueCouldNotBeCreatedException;
use RunAsRoot\MessageQueueRetry\Exception\FailedQueueNotBeDeletedException;
use RunAsRoot\MessageQueueRetry\Exception\FailedQueueNotFoundException;
use RunAsRoot\MessageQueueRetry\Model\FailedQueue;
use RunAsRoot\MessageQueueRetry\Repository\Command\CreateFailedQueueCommand;
use RunAsRoot\MessageQueueRetry\Repository\Command\DeleteFailedQueueByIdCommand;
use RunAsRoot\MessageQueueRetry\Repository\Command\DeleteFailedQueueCommand;
use RunAsRoot\MessageQueueRetry\Repository\Query\FindFailedQueueById;

class FailedQueueRepository
{
    public function __construct(
        private CreateFailedQueueCommand $createFailedQueueCommand,
        private DeleteFailedQueueCommand $deleteFailedQueueCommand,
        private DeleteFailedQueueByIdCommand $deleteFailedQueueByIdCommand,
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
        $this->deleteFailedQueueByIdCommand->execute($id);
    }

    /**
     * @throws FailedQueueNotBeDeletedException
     */
    public function delete(FailedQueue $model): void
    {
        $this->deleteFailedQueueCommand->execute($model);
    }
}
