<?php
/**
 * Copyright © (Deki) nooby.dev All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Deki\FlashSale\Observer\Catalog;

class ProductLoadAfter implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
      // area : add to cart first time
      $product = $observer->getEvent()->getProduct();
      if($product && $product->getTypeId() == 'simple'){
        $product->setFinalPrice(30000);
        $product->setSpecialPrice(30000);
        $product->setData('flash_sale_percentage', 90);
        $product->setData('is_flash_sale', true);
      }
    }
}