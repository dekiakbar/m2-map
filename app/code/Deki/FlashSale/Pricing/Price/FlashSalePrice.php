<?php
/**
 * Copyright © (Deki) nooby.dev All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Deki\FlashSale\Pricing\Price;

use Magento\Catalog\Model\Product;
use Magento\CatalogRule\Model\ResourceModel\Rule;
use Magento\Customer\Model\Session;
use Magento\Framework\Pricing\Adjustment\Calculator;
use Magento\Framework\Pricing\Price\AbstractPrice;
use Magento\Framework\Pricing\Price\BasePriceProviderInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Store\Model\StoreManagerInterface;
use Deki\FlashSale\Model\ResourceModel\EventProductPriceFactory;

/**
 * Class FlashSalePrice
 *
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class FlashSalePrice extends AbstractPrice implements BasePriceProviderInterface
{
    /**
     * Price type identifier string
     */
    const PRICE_CODE = 'flash_sale_price';

    /**
     * @var TimezoneInterface
     */
    protected $dateTime;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var EventProductPriceFactory
     */
    private $eventProductPriceFactory;

    /**
     * @param Product $saleableItem
     * @param float $quantity
     * @param Calculator $calculator
     * @param PriceCurrencyInterface $priceCurrency
     * @param TimezoneInterface $dateTime
     * @param StoreManagerInterface $storeManager
     * @param Session $customerSession
     * @param EventProductPriceFactory $eventProductPriceFactory
     */
    public function __construct(
        Product $saleableItem,
        $quantity,
        Calculator $calculator,
        PriceCurrencyInterface $priceCurrency,
        TimezoneInterface $dateTime,
        StoreManagerInterface $storeManager,
        Session $customerSession,
        EventProductPriceFactory $eventProductPriceFactory
    ) {
        parent::__construct($saleableItem, $quantity, $calculator, $priceCurrency);
        $this->dateTime = $dateTime;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->eventProductPriceFactory = $eventProductPriceFactory;
    }

    /**
     * Returns flas sale price value (apply to PDP and PLP)
     *
     * @return float|boolean
     */
    public function getValue()
    {
        if (null === $this->value) {
            if ($this->product->hasData(self::PRICE_CODE)) {
                $value = $this->product->getData(self::PRICE_CODE);
                $this->value = $value ? (float)$value : false;
            } else {
                $flashSalePriceInfo = $this->eventProductPriceFactory->create()->getFlashSalePriceInfo(
                    $this->dateTime->scopeDate($this->storeManager->getStore()->getId(), null, true),
                    $this->product->getId()
                );
                $this->value = $flashSalePriceInfo ? (float)$flashSalePriceInfo['price'] : false;
            }
            if ($this->value) {
                $this->value = $this->priceCurrency->convertAndRound($this->value);
            }
        }

        return $this->value;
    }
}
