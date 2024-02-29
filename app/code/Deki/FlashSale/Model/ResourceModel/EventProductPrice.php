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
     * @param int $pId
     * @return float|false
     */
    public function getFlashSalePrice($date, $pId)
    {
        $data = $this->getFlashSalePrices($date, [$pId]);
        if (isset($data[$pId])) {
            return $data[$pId];
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
            ->where('product_id IN(?)', $productIds, \Zend_Db::INT_TYPE);

        return $connection->fetchPairs($select);
    }
}

