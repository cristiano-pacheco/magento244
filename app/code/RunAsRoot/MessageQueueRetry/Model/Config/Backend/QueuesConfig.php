<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Model\Config\Backend;
use Magento\Config\Model\Config\Backend\Serialized\ArraySerialized;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;

class QueuesConfig extends ArraySerialized
{
    private StoreViewCodeValidator $storeViewCodeValidator;

    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = [],
        Json $serializer = null
    ) {
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data,
            $serializer
        );
    }

    /**
     * @throws LocalizedException
     */
    public function beforeSave()
    {
        $value = $this->getValue();

        if (!is_array($value)) {
            return parent::beforeSave();
        }

        foreach ($value as $configValue) {
//            if (!isset($configValue[HreflangMappingColumnEnumInterface::STORE_VIEW_CODE])) {
//                continue;
//            }
//
//            $this->storeViewCodeValidator->isValid(
//                $configValue[HreflangMappingColumnEnumInterface::STORE_VIEW_CODE]
//            );
        }

        return parent::beforeSave();
    }
}
