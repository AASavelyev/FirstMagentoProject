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
 * OneClick orders model
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Model_OneClickOrder extends Mage_Core_Model_Abstract
{
    const NEW_STATUS = 1;
    const REJECTED_STATUS = 2;
    const HANDLED_STATUS = 3;
    const CREATE_ORDER_MESSAGE = 'Created order #';

    /**
     * init oneClick order model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('oggetto_oneClick/oneClickOrder');
    }

    /**
     * Save order
     *
     * @param array $data info about order
     * @return void
     */
    public function saveOrder($data)
    {
        try {
            $this->setData($data)
                ->setDate(date('Y-m-d H:i:s'))
                ->setState(self::NEW_STATUS)
                ->setStoreId(Mage::helper('oggetto_oneClick')->getStoreId())
                ->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    /**
     * Cancel order
     *
     * @param int $id order id
     * @return void
     */
    public function cancelOrder($id)
    {
        try {
            $this->load($id)->setState(self::REJECTED_STATUS)->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    /**
     * Handle order
     *
     * @param int $id order id
     * @return void
     */
    public function handleOrder($id)
    {
        try {
            $this->load($id)->setState(self::HANDLED_STATUS)->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }
}
