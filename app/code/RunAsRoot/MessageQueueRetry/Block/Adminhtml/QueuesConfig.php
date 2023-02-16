<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Block\Adminhtml;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class QueuesConfig extends AbstractFieldArray
{
    protected function _prepareToRender()
    {
        $this->addColumn(
            'queue_name',
            [ 'label' => __('Queue Name'), 'class' => 'required-entry' ]
        );

        $this->addColumn(
            'delay_in_seconds',
            [ 'label' => __('Delay In Seconds'), 'class' => 'required-entry' ]
        );

        $this->addColumn(
            'retry_limit',
            [ 'label' => __('Retry Limit'), 'class' => 'required-entry' ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = 'Add';
    }
}
