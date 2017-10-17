<?php


namespace SuttonSilver\OutOfStockNotification\Controller\Index;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;

class Notify extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $notificationsRepository;
    protected $notificationsinterface;
    protected $messageManager;
    protected $emailHelper;
    protected $validator;
    protected $searchCriteriaBuilder;
    protected $filterBuilder;


    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \SuttonSilver\OutOfStockNotification\Model\NotificationsRepository $notificationsRepository,
        \SuttonSilver\OutOfStockNotification\Api\Data\NotificationsInterface $notificationsinterface,
        \SuttonSilver\OutOfStockNotification\Helper\Email $emailHelper,
        \Magento\Framework\Data\Form\FormKey\Validator $validator,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->notificationsRepository = $notificationsRepository;
        $this->notificationsinterface = $notificationsinterface;
        $this->messageManager  = $context->getMessageManager();
        $this->emailHelper = $emailHelper;
        $this->validator = $validator;

        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;

        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $post = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultFactory->create('redirect');
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        if(!$this->validator->validate($this->getRequest()))
        {
            $this->runError("We Could not validate the form:");
            return $resultRedirect;
        }

        $notifications = $this->getNotifications($post['email'],$post['product']);

        if(count($notifications) > 0) {
            $this->messageManager->addSuccessMessage(
                __('Thanks for your interest, we will notify you when the course becomes available'),
                'outofstock'
            );
            return $resultRedirect;
        }



        $data = [];
        $data['email'] = $this->notificationsinterface->setEmail($post['email']);
        $data['product_id'] =$this->notificationsinterface->setProductId($post['product']);


        try {
            $this->notificationsRepository->save($this->notificationsinterface);


            $this->messageManager->addSuccessMessage(
                __('Thanks for your interest, we will notify you when the course becomes available'),
                'outofstock'
            );

            $this->emailHelper->sendSubscribedEmail($post['email'], $post['product']);

        }catch(\Exception $e)
        {
            $this->runError($e->getMessage());
        }



        return $resultRedirect;
    }

    public function getNotifications($email, $product)
    {
        $filters[] = $this->filterBuilder
            ->setField('email')
            ->setConditionType('eq')
            ->setValue($email)
            ->create();

        $filters[] = $this->filterBuilder
            ->setField('product_id')
            ->setConditionType('eq')
            ->setValue($product)
            ->create();

        $this->searchCriteriaBuilder->addFilters($filters);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResults = $this->notificationsRepository->getList($searchCriteria);
        return $searchResults->getItems();
    }

    public function runError($e){
        $error = $e." ".
            __('We ran into a problem, subscribing you to the product notification');
        $this->messageManager->addErrorMessage($error,
        'outofstock'
        );
        return $this;
    }


}
