<?php


namespace SuttonSilver\OutOfStockNotification\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface NotificationsRepositoryInterface
{


    /**
     * Save Notifications
     * @param \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface $notifications
     * @return \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function save(
        \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface $notifications
    );

    /**
     * Retrieve Notifications
     * @param string $notificationsId
     * @return \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getById($notificationsId);

    /**
     * Retrieve Notifications matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Notifications
     * @param \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface $notifications
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function delete(
        \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface $notifications
    );

    /**
     * Delete Notifications by ID
     * @param string $notificationsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function deleteById($notificationsId);
}
