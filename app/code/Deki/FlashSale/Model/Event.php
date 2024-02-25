<?php
/**
 * Copyright © (Deki) nooby.dev All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Deki\FlashSale\Model;

use Deki\FlashSale\Api\Data\EventInterface;
use Magento\Framework\Model\AbstractModel;

class Event extends AbstractModel implements EventInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Deki\FlashSale\Model\ResourceModel\Event::class);
    }

    /**
     * @inheritDoc
     */
    public function getEventId()
    {
        return $this->getData(self::EVENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEventId($eventId)
    {
        return $this->setData(self::EVENT_ID, $eventId);
    }

    /**
     * @inheritDoc
     */
    public function getIsEnabled()
    {
        return $this->getData(self::IS_ENABLED);
    }

    /**
     * @inheritDoc
     */
    public function setIsEnabled($isEnabled)
    {
        return $this->setData(self::IS_ENABLED, $isEnabled);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getCategoryId()
    {
        return $this->getData(self::CATEGORY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCategoryId($categoryId)
    {
        return $this->setData(self::CATEGORY_ID, $categoryId);
    }

    /**
     * @inheritDoc
     */
    public function getDateTimeFrom()
    {
        return $this->getData(self::DATE_TIME_FROM);
    }

    /**
     * @inheritDoc
     */
    public function setDateTimeFrom($dateTimeFrom)
    {
        return $this->setData(self::DATE_TIME_FROM, $dateTimeFrom);
    }

    /**
     * @inheritDoc
     */
    public function getDateTimeTo()
    {
        return $this->getData(self::DATE_TIME_TO);
    }

    /**
     * @inheritDoc
     */
    public function setDateTimeTo($dateTimeTo)
    {
        return $this->setData(self::DATE_TIME_TO, $dateTimeTo);
    }
}

