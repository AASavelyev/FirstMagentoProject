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
 * OneClick log model
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Model_OneClickLog extends Mage_Core_Model_Abstract
{
    const NEW_STATUS = 1;
    const REJECTED_STATUS = 2;
    const HANDLED = 3;
    /**
     * init oneClick log model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('oggetto_oneClick/oneClickLog');
    }

    /**
     * Save log
     *
     * @param int $orderId order id
     * @return void
     */
    public function saveLog($orderId)
    {
        try {
            $this->setOrderId($orderId)
                ->setDate(Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'))
                ->setState(self::NEW_STATUS)
                ->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }

    }

    /**
     * log new event
     *
     * @param int    $orderId order id
     * @param string $comment comment
     * @param int    $state   state
     * @return void
     */
    public function log($orderId, $comment, $state)
    {
        try {
            $this->setOrderId($orderId)
                ->setDate(Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'))
                ->setState($state)
                ->setUsername(Mage::helper('oggetto_oneClick/user')->getAdminName())
                ->setComment($comment)
                ->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    /**
     * get Status Text
     *
     * @param int $status status
     * @return string
     */
    public function getStatusText($status)
    {
        return Mage::getModel('oggetto_oneClick/status')->getOptionText($status);
    }
}
