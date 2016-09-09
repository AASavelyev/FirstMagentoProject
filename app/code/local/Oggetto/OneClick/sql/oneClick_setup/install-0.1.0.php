<?php
/**
 * Oggetto Web extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto OneClick module to newer versions in the future.
 * If you wish to customize the Oggetto OneClick module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

try {
    $installer = $this;
    $installer->startSetup();
    $table = $installer->getConnection()->newTable($installer->getTable('oggetto_oneClick/oneClickOrders'))
        ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'identity' => true,
        ), 'Order ID')
        ->addColumn('username', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Username')
        ->addColumn('phone', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Phone')
        ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
        ), 'Product id')
        ->addColumn('date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Date')
        ->addColumn('state', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
        ), 'Orser`s state')
        ->setComment('New oneClickOrders table');
    $installer->getConnection()->createTable($table);

    $table = $installer->getConnection()->newTable($installer->getTable('oggetto_oneClick/oneClickLogs'))
        ->addColumn('log_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'identity' => true,
        ), 'Log ID')
        ->addColumn('username', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Username')
        ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
        ), 'Order id')
        ->addColumn('date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Date')
        ->addColumn('comment', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Comment')
        ->addColumn('state', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
        ), 'State')
        ->setComment('New oneClickLogs table');
    $installer->getConnection()->createTable($table);

    $installer->getConnection()
        ->addForeignKey(
            $installer->getFkName('oggetto_oneClick/oneClickLogs', 'order_id',
                'oggetto_oneClick/oneClickOrders', 'order_id'),
            'order_id',
            $installer->getTable('oggetto_oneClick/oneClickOrders'),
            'order_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE,
            Varien_Db_Ddl_Table::ACTION_CASCADE
    );

    $installer->endSetup();
} catch (Exception $e) {
    Mage::logException($e);
}
