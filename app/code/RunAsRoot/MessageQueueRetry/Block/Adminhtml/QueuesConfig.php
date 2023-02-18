<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Block\Adminhtml;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class QueuesConfig extends AbstractFieldArray
{
    protected function _prepareToRender(): void
    {
        $this->addColumn(
            MessageQueueRetryConfig::DELAY_TOPIC_NAME,
            [ 'label' => __('Delay Topic Name'), 'class' => 'required-entry' ]
        );

        $this->addColumn(
            MessageQueueRetryConfig::RETRY_LIMIT,
            [ 'label' => __('Retry Limit'), 'class' => 'required-entry validate-zero-or-greater' ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = 'Add';
    }
}
