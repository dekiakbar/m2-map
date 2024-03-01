<?php
/**
 * Copyright © (Deki) nooby.dev All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Deki\FlashSale\Plugin\Indexer\Product\Save;

use Deki\FlashSale\Model\Indexer\EventProductPriceProcessor;

class ApplyFlashSale
{
    /**
     * @var EventProductPriceProcessor
     */
    protected $eventProductPriceProcessor;

    /**
     * @param EventProductPriceProcessor $eventProductPriceProcessor
     */
    public function __construct(EventProductPriceProcessor $eventProductPriceProcessor)
    {
        $this->eventProductPriceProcessor = $eventProductPriceProcessor;
    }

    /**
     * Apply flash sale price after product resource model save
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product $subject
     * @param \Magento\Catalog\Model\ResourceModel\Product $productResource
     * @param \Magento\Framework\Model\AbstractModel $product
     * @return \Magento\Catalog\Model\ResourceModel\Product
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSave(
        \Magento\Catalog\Model\ResourceModel\Product $subject,
        \Magento\Catalog\Model\ResourceModel\Product $productResource,
        \Magento\Framework\Model\AbstractModel $product
    ) {
        if (!$product->getIsMassupdate()) {
            // TODO: maybe index only 1 product
            $this->eventProductPriceProcessor->markIndexerAsInvalid();
        }
        return $productResource;
    }
}
