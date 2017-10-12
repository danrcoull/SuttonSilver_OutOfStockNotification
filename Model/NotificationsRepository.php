<?php


namespace SuttonSilver\OutOfStockNotification\Model;

use SuttonSilver\OutOfStockNotification\Model\ResourceModel\Notifications\CollectionFactory as NotificationsCollectionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\DataObjectHelper;
use SuttonSilver\OutOfStockNotification\Api\NotificationsRepositoryInterface;
use SuttonSilver\OutOfStockNotification\Api\Data\NotificationsSearchResultsInterfaceFactory;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\SortOrder;
use SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterfaceFactory;
use SuttonSilver\OutOfStockNotification\Model\ResourceModel\Notifications as ResourceNotifications;

class NotificationsRepository implements NotificationsRepositoryInterface
{

    protected $NotificationsFactory;

    private $storeManager;

    protected $resource;

    protected $NotificationsCollectionFactory;

    protected $dataNotificationsFactory;

    protected $dataObjectProcessor;

    protected $dataObjectHelper;

    protected $searchResultsFactory;


    /**
     * @param ResourceNotifications $resource
     * @param NotificationsFactory $notificationsFactory
     * @param NotificationsInterfaceFactory $dataNotificationsFactory
     * @param NotificationsCollectionFactory $notificationsCollectionFactory
     * @param NotificationsSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceNotifications $resource,
        NotificationsFactory $notificationsFactory,
        NotificationsInterfaceFactory $dataNotificationsFactory,
        NotificationsCollectionFactory $notificationsCollectionFactory,
        NotificationsSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->notificationsFactory = $notificationsFactory;
        $this->notificationsCollectionFactory = $notificationsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataNotificationsFactory = $dataNotificationsFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface $notifications
    ) {
        /* if (empty($notifications->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $notifications->setStoreId($storeId);
        } */
        try {
            $notifications->getResource()->save($notifications);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the notifications: %1',
                $exception->getMessage()
            ));
        }
        return $notifications;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($notificationsId)
    {
        $notifications = $this->notificationsFactory->create();
        $notifications->getResource()->load($notifications, $notificationsId);
        if (!$notifications->getId()) {
            throw new NoSuchEntityException(__('Notifications with id "%1" does not exist.', $notificationsId));
        }
        return $notifications;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->notificationsCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface $notifications
    ) {
        try {
            $notifications->getResource()->delete($notifications);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Notifications: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($notificationsId)
    {
        return $this->delete($this->getById($notificationsId));
    }
}
