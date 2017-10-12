<?php
namespace SuttonSilver\OutOfStockNotification\Block;
use Magento\Framework\View\Element\Message\InterpretationStrategyInterface;
/**
 * Zengoma MessageManagerExample display messages block
 */
class DisplayMessages extends \Magento\Framework\View\Element\Messages
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Message\Factory $messageFactory
     * @param \Magento\Framework\Message\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param InterpretationStrategyInterface $interpretationStrategy
     * @param array $data
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Message\Factory $messageFactory,
        \Magento\Framework\Message\CollectionFactory $collectionFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        InterpretationStrategyInterface $interpretationStrategy,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $messageFactory,
            $collectionFactory,
            $messageManager,
            $interpretationStrategy,
            $data
        );
    }
    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        $messages = $this->messageManager->getMessages(true,"outofstock");
        $this->addMessages($messages);
        return parent::_prepareLayout();
    }
}