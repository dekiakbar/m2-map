<?php
/**
 * Copyright © (Deki) nooby.dev All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Deki\FlashSale\Observer;
use Deki\FlashSale\Model\FlashSaleService;

class DeductQuantityAfterOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var FlashSaleService
     */
    protected $flashSaleService;

    /**
     *
     * @param FlashSaleService $flashSaleService
     */
    public function __construct(
        FlashSaleService $flashSaleService
    ){
        $this->flashSaleService = $flashSaleService;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getQuote();
        $items = $quote->getItemsCollection();

        foreach($items as $item){
            if($item->getData('is_flash_sale')){
                $this->flashSaleService->deductEventProductQty(
                    $item->getData('flash_sale_event_product_id'),
                    $item->getQty()
                );
            }
        }
    }
}
