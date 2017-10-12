<?php


namespace SuttonSilver\OutOfStockNotification\Controller\Index;

class Notify extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $notificationsRepository;
    protected $notificationsinterface;
    protected $messageManager;
    protected $emailHelper;
    protected $validator;


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
        \Magento\Framework\Data\Form\FormKey\Validator $validator
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->notificationsRepository = $notificationsRepository;
        $this->notificationsinterface = $notificationsinterface;
        $this->messageManager  = $context->getMessageManager();
        $this->emailHelper = $emailHelper;
        $this->validator = $validator;

        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $this->messageManager->addSuccess(
            __('Thanks for your interest, we will notify you when the course becomes available'),
            'outofstock'
        );

        $post = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultFactory->create('redirect');
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        if($this->validator->validate($this->getRequest()))
        {
            $this->runError("We Could not validate the form:");
            return $resultRedirect;
        }

        $data = [];
        $data['email'] = $this->notificationsinterface->setEmail($post['email']);
        $data['product_id'] =$this->notificationsinterface->setProductId($post['product']);


        try {
            $return = $this->notificationsRepository->save($this->notificationsinterface);


            $this->messageManager->addSuccessMessage(
                __('Thanks for your interest, we will notify you when the course becomes available'),
                'outofstock'
            );

            $this->emailHelper->sendSubscribedEmail($post['email'], $post['product']);

        }catch(\Exception $e)
        {
            $this->runError($e);
        }



        return $resultRedirect;
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
