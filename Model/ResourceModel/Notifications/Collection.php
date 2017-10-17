<?php


namespace SuttonSilver\OutOfStockNotification\Model\ResourceModel\Notifications;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'SuttonSilver\OutOfStockNotification\Model\Notifications',
            'SuttonSilver\OutOfStockNotification\Model\ResourceModel\Notifications'
        );
    }

    protected function _initSelect() {

        parent::_initSelect();

        $this->getSelect()->joinLeft(
            ['product_entity' => $this->getTable('catalog_product_entity')],
            'main_table.product_id = product_entity.entity_id',
            ['*']
        );

    }
}
