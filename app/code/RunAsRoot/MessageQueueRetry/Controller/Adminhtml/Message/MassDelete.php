<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Controller\Adminhtml\Message;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Ui\Component\MassAction\Filter;
use RunAsRoot\MessageQueueRetry\Model\ResourceModel\FailedQueue\CollectionFactory;
use RunAsRoot\MessageQueueRetry\Repository\FailedQueueRepository;

class MassDelete extends Action
{
    public const ADMIN_RESOURCE = 'RunAsRoot_MessageQueueRetry::failed_queue';

    public function __construct(
        Context $context,
        private FailedQueueRepository $failedQueueRepository,
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

            foreach ($collection as $failedQueueItem) {
                $this->failedQueueRepository->delete($failedQueueItem);
            }

            $this->messageManager->addSuccessMessage(__('The messages have been successfully deleted'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('An error occurred while trying to delete the messages: %1', $e->getMessage())
            );
        }

        return $redirect->setPath('failed_queue/index/index');
    }
}
