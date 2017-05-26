<?php

namespace SuttonSilver\OutOfStockNotification\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class ChangeTemplate implements ObserverInterface
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Product
     */
    private $product;

    public function __construct(
        Registry $registry
    ) {
        $this->registry = $registry;
    }

    public function execute(Observer $observer)
    {
        if($product = $this->getProduct()) {

            /** @var \Magento\Framework\View\Layout $layout */
            $layout = $observer->getLayout();
            $layout->getUpdate()->addHandle('catalog_product_view_unvailable');
            if (!$product->load($product->getId())->isInStock()) {
                $layout->getUpdate()->addHandle('catalog_product_view_unvailable');
            }
        }
    }

    /**
     * @return Product
     */
    private function getProduct()
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('product');

            if (!$this->product) {
                return false;
            }
        }

        return $this->product;
    }
}