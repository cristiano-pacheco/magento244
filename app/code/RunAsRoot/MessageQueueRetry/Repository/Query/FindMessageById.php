<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Repository\Query;

use RunAsRoot\MessageQueueRetry\Model\Message;
use RunAsRoot\MessageQueueRetry\Model\FailedQueueFactory as ModelFactory;
use RunAsRoot\MessageQueueRetry\Model\ResourceModel\Message as ResourceModel;
use RunAsRoot\MessageQueueRetry\Exception\MessageNotFoundException;

class FindMessageById
{
    public function __construct(
        private ResourceModel $resourceModel,
        private ModelFactory $modelFactory
    ) {
    }

    /**
     * @throws MessageNotFoundException
     */
    public function execute(int $entityId): Message
    {
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $entityId);

        if (!$model->getId()) {
            throw new MessageNotFoundException(__('Message with id "%1" could not be found.', $entityId));
        }

        return $model;
    }
}