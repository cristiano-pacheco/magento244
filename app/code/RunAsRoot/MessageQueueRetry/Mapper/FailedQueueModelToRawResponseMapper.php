<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Mapper;

use Magento\Framework\Controller\Result\Raw as RawResponse;
use RunAsRoot\MessageQueueRetry\Exception\EmptyQueueMessageBodyException;
use RunAsRoot\MessageQueueRetry\Model\FailedQueue;
use RunAsRoot\MessageQueueRetry\Builder\MessageBodyDownloadFileNameBuilder;

class FailedQueueModelToRawResponseMapper
{
    public function __construct(
        private MessageBodyDownloadFileNameBuilder $messageBodyDownloadFileNameBuilder
    ) {
    }

    /**
     * @throws EmptyQueueMessageBodyException
     */
    public function map(FailedQueue $failedQueueModel, RawResponse $rawResponse): RawResponse
    {
        if (!$failedQueueModel->getMessageBody()) {
            throw new EmptyQueueMessageBodyException(__('Message body is empty'));
        }

        $contentLength = strlen($failedQueueModel->getMessageBody());
        $fileName = $this->messageBodyDownloadFileNameBuilder->build($failedQueueModel);

        $rawResponse->setHttpResponseCode(200);
        $rawResponse->setHeader('Pragma', 'public', true);
        $rawResponse->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $rawResponse->setHeader('Content-type', 'application/json', true);
        $rawResponse->setHeader('Content-Length', $contentLength, true);
        $rawResponse->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"', true);
        $rawResponse->setContents($failedQueueModel->getMessageBody());

        return $rawResponse;
    }
}
