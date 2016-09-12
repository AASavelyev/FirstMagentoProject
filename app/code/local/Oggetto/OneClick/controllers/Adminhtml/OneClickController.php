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
 * Admin controller for management one click orders
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Adminhtml_OneClickController extends Mage_Adminhtml_Controller_Action
{
    /**
     * index action, show all one click orders in standard table
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * edit action, prepare data for edit
     *
     * @return void
     */
    public function editAction()
    {
        try
        {
            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('oggetto_oneClick/oneClickOrder')->load($id);
            $this->_setModelProductInfo($model);
            Mage::register('oneClick_orderInfo', $model);
        } catch (Exception $e) {
            Mage::logException($e);
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * set product name, url and product price fields
     *
     * @param Oggetto_OneClick_Model_OneClickOrder $model model of one click order
     * @return void
     */
    private function _setModelProductInfo($model)
    {
        $helper = Mage::helper('oggetto_oneClick');
        $productId = $model->getProductId();
        $model->setProductName($helper->getProductName($productId));
        $model->setProductUrl($helper->getProductUrl($productId));
        $model->setProductPrice($helper->getProductPrice($productId));
    }

    /**
     * show new page with one textarea where admin write why he rejected one click order
     *
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        Mage::register('order_id', $id);
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * cancel one click order
     *
     * @return void
     */
    public function cancelAction()
    {
        $params = $this->getRequest()->getParams();
        try {
            Mage::getModel('oggetto_oneClick/oneClickOrder')->cancelOrder($params['order_id']);
            Mage::getModel('oggetto_oneClick/oneClickLog')
                ->log($params['order_id'], $params['comment'], Oggetto_OneClick_Model_Status::REJECTED_STATUS);
        } catch (Exception $e) {
            Mage::logException($e);
        }
        $this->_redirect('/oneClick/index');
    }

    /**
     * create real order
     *
     * @return void
     */
    public function saveAction()
    {
        try {
            $orderId = $this->getRequest()->getParam('order_id');
            $order = Mage::getModel('oggetto_oneClick/oneClickOrder')->load($orderId);
            Mage::getModel('oggetto_oneClick/order')->initFromOrder($order);
        } catch (Exception $e) {
            Mage::logException($e);
        }
        $this->_redirect('/sales_order_create/');
    }
}
