<?php


namespace SuttonSilver\OutOfStockNotification\Api\Data;

interface NotificationsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Notifications list.
     * @return \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface[]
     */
    
    public function getItems();

    /**
     * Set entity_id list.
     * @param \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface[] $items
     * @return $this
     */
    
    public function setItems(array $items);
}
