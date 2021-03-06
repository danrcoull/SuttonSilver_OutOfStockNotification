<?php


namespace SuttonSilver\OutOfStockNotification\Cron;

class SendNotification
{

    protected $logger;
    protected $notificationsSearchResults;
    protected $notificationsRepository;
    protected $productRepository;
    protected $emailHelper;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \SuttonSilver\OutOfStockNotification\Model\ResourceModel\Notifications\CollectionFactory $notificationsSearchResults,
        \SuttonSilver\OutOfStockNotification\Model\NotificationsRepository $notificationsRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \SuttonSilver\OutOfStockNotification\Helper\Email $emailHelper
    )
    {
        $this->logger = $logger;
        $this->notificationsSearchResults = $notificationsSearchResults;
        $this->notificationsRepository = $notificationsRepository;
        $this->productRepository = $productRepository;
        $this->emailHelper = $emailHelper;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $this->logger->addInfo("Cronjob SendNotification is executed.");
        $notifications = $this->notificationsSearchResults->create();
        foreach($notifications as $notification)
        {
            $notification = $this->notificationsRepository->getById($notification->getId());
            $product = $this->productRepository->getById($notification->getProductId());
            if($product->isInStock())
            {
                $this->emailHelper->sendBackInStockEmail($notification->getEmail(), $notification->getProductId());
                try {
                    $this->notificationsRepository->delete($notification);
                    $this->logger->info($notification->getId() . " Has been deleted");
                }catch(\Excepton $e)
                {
                    $this->logger->error($e->getMessage());
                }
            }
        }


    }
}
