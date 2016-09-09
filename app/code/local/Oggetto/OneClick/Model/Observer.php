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
 * update one click order when main order is submitted
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Model_Observer
{
    /**
     * catch event when order is submit
     *
     * @param array $observer observer
     * @return void
     */
    public function updateOrder($observer)
    {
        $orderId = $observer->getEvent()->getQuote()->getOneClickOrderId();
        if ($orderId) {
            try {
                Mage::getModel('oggetto_oneClick/oneClickOrder')->handleOrder($orderId);
                Mage::getModel('oggetto_oneClick/oneClickLog')->log(
                    $orderId,
                    Oggetto_OneClick_Model_OneClickOrder::CREATE_ORDER_MESSAGE . $orderId,
                    Oggetto_OneClick_Model_OneClickOrder::HANDLED_STATUS
                );
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
    }
}
