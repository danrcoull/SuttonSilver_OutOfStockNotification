<?php
namespace SuttonSilver\OutOfStockNotification\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Email extends AbstractHelper
{

    protected $inlineTranslation;
    protected $transportBuilder;
    protected $storeManager;
    protected $scopeConfig;
    protected $productRepository;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    )
    {
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;

        parent::__construct($context);
    }

    public function getStorename()
    {
        return $this->scopeConfig->getValue(
            'trans_email/ident_sales/name',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getStoreEmail()
    {
        return $this->scopeConfig->getValue(
            'trans_email/ident_sales/email',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getFromArray(){
        return array('email' => $this->getStoreEmail(), 'name' => $this->getStorename());
    }

    public function getTemplateOptionsArray(){
        return  array('area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->storeManager->getStore()->getId());
    }

    public function sendSubscribedEmail($email, $productId){
        $product = $this->productRepository->getById($productId);

        $templateVars = array(
            'store' => $this->storeManager->getStore(),
            'customer_name' => $email,
            'message'   => 'Thanks for your registering your interest in '.$product->getName()
        );

        $this->inlineTranslation->suspend();

        $transport = $this->transportBuilder->setTemplateIdentifier('subscribed_template')
            ->setTemplateOptions($this->getTemplateOptionsArray())
            ->setTemplateVars($templateVars)
            ->setFrom($this->getFromArray())
            ->addTo(array($email))
            ->getTransport();

        $transport->sendMessage();

        $this->inlineTranslation->resume();
    }


    public function sendBackInStockEmail($email, $productId){
        $product = $this->productRepository->getById($productId);

        $templateVars = array(
            'store' => $this->storeManager->getStore(),
            'customer_name' => $email,
            'message'   => 'Thanks for your registering your interest our product is back in stock',
            'product'   =>$product->getName(),
            'producturl'   =>$product->getUrl()
        );

        $this->inlineTranslation->suspend();

        $transport = $this->transportBuilder->setTemplateIdentifier('instock_template')
            ->setTemplateOptions($this->getTemplateOptionsArray())
            ->setTemplateVars($templateVars)
            ->setFrom($this->getFromArray())
            ->addTo(array($email))
            ->getTransport();

        $transport->sendMessage();

        $this->inlineTranslation->resume();
    }
}