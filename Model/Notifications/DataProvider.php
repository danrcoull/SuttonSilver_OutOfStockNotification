<?php


namespace SuttonSilver\OutOfStockNotification\Model\Notifications;

use Magento\Framework\App\Request\DataPersistorInterface;
use SuttonSilver\OutOfStockNotification\Model\ResourceModel\Notifications\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $loadedData;
    protected $dataPersistor;

    protected $collection;
    protected $config;


    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Eav\Model\Config $config,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->config = $config;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }


        $productNameAttributeId = $this->config
            ->getAttribute(\Magento\Catalog\Model\Product::ENTITY, \Magento\Catalog\Api\Data\ProductInterface::NAME)
            ->getAttributeId();

        $this->collection->getSelect()->join(
            ['product_entity' => $this->collection->getTable('catalog_product_entity')],
            'main_table.product_id = product_entity.entity_id',
            ['entity_id', 'sku']
        );

        $this->collection->getSelect()->joinLeft(
            ['product_varchar' => $this->collection->getTable('catalog_product_entity_varchar')],
            "product_varchar.entity_id = product_entity.entity_id AND product_varchar.attribute_id = $productNameAttributeId",
            ['product_name']

        );


        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('suttonsilver_outofstocknotification_notifications');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('suttonsilver_outofstocknotification_notifications');
        }
        
        return $this->loadedData;
    }
}
