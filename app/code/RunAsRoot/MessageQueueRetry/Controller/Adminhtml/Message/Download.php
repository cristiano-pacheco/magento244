<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Controller\Adminhtml\Message;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Raw as RawResponse;
use Magento\Framework\Controller\Result\RawFactory;
use RunAsRoot\MessageQueueRetry\Exception\EmptyQueueMessageBodyException;
use RunAsRoot\MessageQueueRetry\Exception\FailedQueueNotFoundException;
use RunAsRoot\MessageQueueRetry\Mapper\FailedQueueModelToRawResponseMapper;
use RunAsRoot\MessageQueueRetry\Repository\FailedQueueRepository;

class Download extends Action
{
    public const ADMIN_RESOURCE = 'RunAsRoot_MessageQueueRetry::failed_queue';

    public function __construct(
        Context $context,
        private FailedQueueRepository $failedQueueRepository,
        private RawFactory $rawFactory,
        private FailedQueueModelToRawResponseMapper $failedQueueModelToRawResponseMapper
    ) {
        parent::__construct($context);
    }

    /**
     * @throws EmptyQueueMessageBodyException
     * @throws FailedQueueNotFoundException
     */
    public function execute(): RawResponse
    {
        $messageId = (int)$this->getRequest()->getParam('message_id');
        $failedQueueModel = $this->failedQueueRepository->findById($messageId);
        $rawResponse = $this->rawFactory->create();
        $this->failedQueueModelToRawResponseMapper->map($failedQueueModel, $rawResponse);

        return $rawResponse;
    }
}
