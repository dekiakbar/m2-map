<?php
/**
 * Copyright © (Deki) nooby.dev All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Deki\FlashSale\Model;
use Deki\FlashSale\Model\EventProductRepository;
use \Deki\FlashSale\Api\Data\EventProductInterface;

class FlashSaleService {

    /**
     * @var EventProductRepository
     */
    protected $eventProductRepository;

    /**
     * @param EventProductRepository $eventProductRepository
     */
    public function __construct(
        EventProductRepository $eventProductRepository
    ){
        $this->eventProductRepository = $eventProductRepository;
    }

    /**
     * Deduct flash sale product Qty
     *
     * @param int $eventProductId
     * @param int $qty
     * @return EventProductInterface
     */
    public function deductEventProductQty($eventProductId, $qty)
    {
        $eventProduct = $this->eventProductRepository->get($eventProductId);
        $eventProduct->setQty(($eventProduct->getQty() - (int)$qty));
        return $this->eventProductRepository->save($eventProduct);
    }
}