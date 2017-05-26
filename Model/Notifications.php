<?php


namespace SuttonSilver\OutOfStockNotification\Model;

use SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface;

class Notifications extends \Magento\Framework\Model\AbstractModel implements NotificationsInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('SuttonSilver\OutOfStockNotification\Model\ResourceModel\Notifications');
    }

    /**
     * Get notifications_id
     * @return string
     */
    public function getNotificationsId()
    {
        return $this->getData(self::NOTIFICATIONS_ID);
    }

    /**
     * Set notifications_id
     * @param string $notificationsId
     * @return \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface
     */
    public function setNotificationsId($notificationsId)
    {
        return $this->setData(self::NOTIFICATIONS_ID, $notificationsId);
    }

    /**
     * Get entity_id
     * @return string
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set entity_id
     * @param string $entity_id
     * @return \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface
     */
    public function setEntityId($entity_id)
    {
        return $this->setData(self::ENTITY_ID, $entity_id);
    }

    /**
     * Get email
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Set email
     * @param string $email
     * @return \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Get product_id
     * @return string
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * Set product_id
     * @param string $product_id
     * @return \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface
     */
    public function setProductId($product_id)
    {
        return $this->setData(self::PRODUCT_ID, $product_id);
    }
}
