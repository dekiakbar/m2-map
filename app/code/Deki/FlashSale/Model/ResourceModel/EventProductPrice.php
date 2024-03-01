<?php
/**
 * Copyright © (Deki) nooby.dev All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Deki\FlashSale\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class EventProductPrice extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('deki_flashsale_event_product_price', 'event_product_price_id');
    }

    /**
     * Get flash sale product price for specific date
     *
     * @param \DateTimeInterface $date
     * @param int $productId
     * @return float|false
     */
    public function getFlashSalePrice($date, $productId)
    {
        $data = $this->getFlashSalePrices($date, [$productId]);
        if (isset($data[$productId])) {
            return $data[$productId];
        }

        return false;
    }

    /**
     * Retrieve product prices by flash sale for specific date
     * Collect data with  product Id => price pairs
     *
     * @param \DateTimeInterface $date
     * @param array $productIds
     * @return array
     */
    public function getFlashSalePrices(\DateTimeInterface $date, $productIds)
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getTable($this->getMainTable()), ['product_id', 'price'])
            ->where('`start_date` <= ?', $date->format('Y-m-d H:i:s'))
            ->where('`end_date` >= ?', $date->format('Y-m-d H:i:s'))
            ->where('deki_flashsale_event_product_price.product_id IN(?)', $productIds, \Zend_Db::INT_TYPE);

        /**
         * Exclude from flash sale if qty is 0 (real time).
         * if qty 0, exclude product from flash sale
         */
        $select->join(
            ['ev' => $this->getTable('deki_flashsale_event_product')],
            'ev.product_id = deki_flashsale_event_product_price.product_id'
            .' AND ev.event_id = deki_flashsale_event_product_price.event_id',
            ['qty' => 'ev.qty']
        );

        $select->where('qty > 0');

        return $connection->fetchPairs($select);
    }
}

