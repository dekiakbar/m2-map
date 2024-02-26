<?php
/**
 * Copyright © (Deki) nooby.dev All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Deki\FlashSale\Plugin\Magento\Catalog\Model\Product;

class Type
{
    public function beforeGetPriceInfo(
        \Magento\Catalog\Model\Product\Type $subject,
        $saleableItem
    ) {
        // area : produk view
        $saleableItem->setSpecialPrice(30000);
        $saleableItem->setData('flash_sale_percentage', 90);
        $saleableItem->setData('is_flash_sale', true);
        return [$saleableItem];
    }
}
