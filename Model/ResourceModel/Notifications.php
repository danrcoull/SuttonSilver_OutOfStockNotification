<?php


namespace SuttonSilver\OutOfStockNotification\Model\ResourceModel;

class Notifications extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('suttonsilver_notifications', 'notifications_id');
    }
}
