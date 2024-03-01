<?php
/**
 * Copyright © (Deki) nooby.dev All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Deki\FlashSale\Plugin\Indexer;

use Deki\FlashSale\Model\Indexer\EventProductPriceProcessor;
use Magento\ImportExport\Model\Import;

class ImportExport
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
     * Invalidate flash sale indexer
     *
     * @param Import $subject
     * @param bool $result
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterImportSource(Import $subject, $result)
    {
        if (!$this->eventProductPriceProcessor->isIndexerScheduled()) {
            $this->eventProductPriceProcessor->markIndexerAsInvalid();
        }
        return $result;
    }
}
