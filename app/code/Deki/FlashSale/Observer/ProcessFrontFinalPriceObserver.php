<?php
/**
 * Copyright © (Deki) nooby.dev All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Deki\FlashSale\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Deki\FlashSale\Model\ResourceModel\EventProductPriceFactory;

/**
 * Observer for applying flash sale price on product for frontend area
 *
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class ProcessFrontFinalPriceObserver implements ObserverInterface
{

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $localeDate;

    /**
     * @var EventProductPriceFactory
     */
    private $eventProductPriceFactory;

    /**
     * @param StoreManagerInterface $storeManager
     * @param TimezoneInterface $localeDate
     * @param EventProductPriceFactory $eventProductPriceFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        TimezoneInterface $localeDate,
        EventProductPriceFactory $eventProductPriceFactory
    ) {
        $this->storeManager = $storeManager;
        $this->localeDate = $localeDate;
        $this->eventProductPriceFactory = $eventProductPriceFactory;
    }

    /**
     * Apply flash sale price to product on frontend (e.g: add to cart)
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $productId = $product->getId();
        $storeId = $product->getStoreId();

        if ($observer->hasDate()) {
            $date = new \DateTime($observer->getEvent()->getDate());
        } else {
            $date = $this->localeDate->scopeDate($storeId, null, true);
        }

        $flashSalePrice = $this->eventProductPriceFactory->create()->getFlashSalePrice($date, $productId);
        if ($flashSalePrice !== false) {
            $finalPrice = min($product->getData('final_price'),$flashSalePrice);
            $product->setFinalPrice($finalPrice);
        }
        return $this;
    }
}
