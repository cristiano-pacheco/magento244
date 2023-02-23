<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Controller\Adminhtml\Message;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use RunAsRoot\MessageQueueRetry\Service\PublishMessageToQueueService;
use RunAsRoot\MessageQueueRetry\Model\ResourceModel\Message\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassRequeue extends Action
{
    public const ADMIN_RESOURCE = 'RunAsRoot_MessageQueueRetry::failed_queue';

    public function __construct(
        Context $context,
        private PublishMessageToQueueService $publishMessageToQueueService,
        private RedirectFactory $redirectFactory,
        private CollectionFactory $collectionFactory,
        private Filter $filter
    ) {
        parent::__construct($context);
    }


    public function execute(): Redirect
    {
        $redirect = $this->redirectFactory->create();

        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());

            foreach ($collection as $message) {
                $this->publishMessageToQueueService->executeByMessage($message);
            }

            $this->messageManager->addSuccessMessage(__('Messages queued successfully'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('An error occurred while trying to requeue the message: %1', $e->getMessage())
            );
        }

        return $redirect->setPath('failed_queue/index/index');
    }
}
