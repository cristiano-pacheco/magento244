<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Mapper;

use Magento\Framework\Controller\Result\Raw as RawResponse;
use RunAsRoot\MessageQueueRetry\Exception\EmptyQueueMessageBodyException;
use RunAsRoot\MessageQueueRetry\Model\Message;
use RunAsRoot\MessageQueueRetry\Builder\MessageBodyDownloadFileNameBuilder;

class MessageToRawResponseMapper
{
    public function __construct(
        private MessageBodyDownloadFileNameBuilder $messageBodyDownloadFileNameBuilder
    ) {
    }

    /**
     * @throws EmptyQueueMessageBodyException
     */
    public function map(Message $message, RawResponse $rawResponse): RawResponse
    {
        if (!$message->getMessageBody()) {
            throw new EmptyQueueMessageBodyException(__('Message body is empty'));
        }

        $contentLength = strlen($message->getMessageBody());
        $fileName = $this->messageBodyDownloadFileNameBuilder->build($message);

        $rawResponse->setHttpResponseCode(200);
        $rawResponse->setHeader('Pragma', 'public', true);
        $rawResponse->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $rawResponse->setHeader('Content-type', 'application/json', true);
        $rawResponse->setHeader('Content-Length', $contentLength, true);
        $rawResponse->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"', true);
        $rawResponse->setContents($message->getMessageBody());

        return $rawResponse;
    }
}
