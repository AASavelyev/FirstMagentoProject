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
 * the Oggetto OneCLick module to newer versions in the future.
 * If you wish to customize the Oggetto OneCLick module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_OneCLick
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Index controller
 *
 * @category   Oggetto
 * @package    Oggetto_OneCLick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * save action saves new one click orders in database
     *
     * @return void
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        $user = Mage::helper('oggetto_oneClick/user')->getUserInfo();
        if ($user != null) {
            $data['phone'] = $user['phone'];
            $data['username'] = $user['username'];
            $data['user_id'] = $user['user_id'];
        }
        $order = Mage::getModel('oggetto_oneClick/oneClickOrder');
        try {
            $order->saveOrder($data);
            Mage::getModel('oggetto_oneClick/oneClickLog')->saveLog($order->getOrderId());
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }
}
