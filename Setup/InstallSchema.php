<?php


namespace SuttonSilver\OutOfStockNotification\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $table_suttonsilver_notifications = $setup->getConnection()->newTable($setup->getTable('suttonsilver_notifications'));

        
        $table_suttonsilver_notifications->addColumn(
            'notifications_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            array('identity' => true,'nullable' => false,'primary' => true,'auto_increment' => true,'unsigned' => true),
            'Entity ID'
        );

        
        $table_suttonsilver_notifications->addColumn(
            'email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => False],
            'email'
        );
        

        
        $table_suttonsilver_notifications->addColumn(
            'product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => False,'unsigned' => true],
            'product_id'
        );

        $table_suttonsilver_notifications->addForeignKey(
            $setup->getFkName(
                $setup->getTable('suttonsilver_notifications'),
                'notifications_id',
                $setup->getTable('catalog_product_entity'),
                'entity_id'
            ),
            'main_id',
            $setup->getTable('catalog_product_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );

        $setup->getConnection()->createTable($table_suttonsilver_notifications);

        $setup->endSetup();
    }
}
