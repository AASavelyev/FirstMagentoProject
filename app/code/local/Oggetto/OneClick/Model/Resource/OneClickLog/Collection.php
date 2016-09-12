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

/**
 * One click logs collection
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Model_Resource_OneClickLog_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * init collection of one click logs
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('oggetto_oneClick/oneClickLog');
    }

    /**
     * Get logs by one click order id
     *
     * @param int $orderId one click order id
     * @return array
     */
    public function getByOrderId($orderId)
    {
        try {
            return $this->addFieldToFilter('main_table.order_id', $orderId);
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }
}
