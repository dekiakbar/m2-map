<?php
namespace Deki\FlashSale\Observer;
 
use Magento\Framework\Event\ObserverInterface;
 
class CopyAtrributeToQuoteItem implements ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quoteItem = $observer->getQuoteItem();
        $product = $observer->getProduct();

        $product->getFinalPrice();

        if($product->getData('is_flash_sale')){
            $quoteItem->setData('is_flash_sale', true);
            $quoteItem->setData('flash_sale_event_id',$product->getData('flash_sale_event_id'));
            $quoteItem->setData('flash_sale_event_product_id',$product->getData('flash_sale_event_product_id'));
        }
        
    }
}