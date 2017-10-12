<?php


namespace SuttonSilver\OutOfStockNotification\Api\Data;

interface NotificationsInterface
{

    const ENTITY_ID = 'entity_id';
    const EMAIL = 'email';
    const NOTIFICATIONS_ID = 'notifications_id';
    const PRODUCT_ID = 'product_id';


    /**
     * Get notifications_id
     * @return string|null
     */
    
    public function getNotificationsId();

    /**
     * Set notifications_id
     * @param string $notifications_id
     * @return \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface
     */
    
    public function setNotificationsId($notificationsId);

    /**
     * Get entity_id
     * @return string|null
     */
    
    public function getEntityId();

    /**
     * Set entity_id
     * @param string $entity_id
     * @return \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface
     */
    
    public function setEntityId($entity_id);

    /**
     * Get email
     * @return string|null
     */
    
    public function getEmail();

    /**
     * Set email
     * @param string $email
     * @return \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface
     */
    
    public function setEmail($email);

    /**
     * Get product_id
     * @return string|null
     */
    
    public function getProductId();

    /**
     * Set product_id
     * @param string $product_id
     * @return \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface
     */
    
    public function setProductId($product_id);
}
