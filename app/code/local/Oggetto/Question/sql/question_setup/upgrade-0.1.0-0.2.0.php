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
 * the Oggetto Video module to newer versions in the future.
 * If you wish to customize the Oggetto Video module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

try {
    $installer = $this;
    $installer->startSetup();
    $tableName = $installer->getTable('questions');
    $installer->getConnection()->addColumn($tableName, 'noticeWhenAnswer', array(
        'nullable' => true,
        'length' => 255,
        'default' => false,
        'type' => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
        'comment' => 'added noticeWhenAnswer column'
    ));

    $installer->endSetup();
} catch (Exception $e) {
    var_dump($e);die;
    Mage::logException($e);
}
