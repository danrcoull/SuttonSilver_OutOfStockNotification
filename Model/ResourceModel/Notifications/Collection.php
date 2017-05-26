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
}
