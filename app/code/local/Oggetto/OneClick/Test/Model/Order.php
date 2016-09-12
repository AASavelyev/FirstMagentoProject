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
 * test order model
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Test_Model_Order extends EcomDev_PHPUnit_Test_Case
{
    /**
     * prepare order
     *
     * @param int $userId user id
     * @return Oggetto_OneClick_Model_OneClickOrder
     */
    private function prepareOrder($userId)
    {
        $order = new Varien_Object(array());
        $order->setUserId($userId);
        $order->setStoreId(42);
        $order->setProductId(2805);
        $order->setOrderId(8991);
        $order->setUsername('Anonymous');
        return $order;
    }

    /**
     * prepare helper data mock
     *
     * @return mock
     */
    private function prepareHelperDataMock()
    {
        $helperDataMock = $this->getHelperMock('oggetto_oneClick', ['getCurrencyCode']);
        $helperDataMock->expects($this->once())->method('getCurrencyCode')->will($this->returnValue('RUB'));
        return $helperDataMock;
    }

    /**
     * prepare session mock
     *
     * @return mock
     */
    private function prepareSessionMock()
    {
        $sessionMock = $this->getModelMock('adminhtml/session_quote',
            ['setCurrencyId', 'setCustomerId', 'setStoreId', 'getStore', 'getId', 'getWebsiteId',
                'getQuote', 'getCustomerGroupId', 'getStoreId', 'addProduct', 'setCustomerIsGuest',
                'setOneClickOrderId', 'setCustomerFirstname', 'save']);
        $sessionMock->expects($this->once())->method('setCurrencyId')->with($this->equalTo('RUB'));
        $sessionMock->expects($this->once())->method('setStoreId')->with($this->equalTo(42));
        $sessionMock->expects($this->any())->method('getStore')->will($this->returnSelf());
        $sessionMock->expects($this->once())->method('getId');
        $sessionMock->expects($this->once())->method('getWebsiteId');
        $sessionMock->expects($this->once())->method('getQuote')->will($this->returnSelf());
        $sessionMock->expects($this->once())->method('getCustomerGroupId')->will($this->returnValue(5));
        $sessionMock->expects($this->once())->method('getStoreId')->will($this->returnValue(73));
        $sessionMock->expects($this->once())->method('addProduct');
        $sessionMock->expects($this->once())->method('setOneClickOrderId')->with(8991);
        $sessionMock->expects($this->once())->method('setCustomerFirstname')->with('Anonymous');
        $sessionMock->expects($this->once())->method('save');
        return $sessionMock;
    }

    /**
     * prepare product module mock
     *
     * @return mock
     */
    private function prepareProductModuleMock()
    {
        $productModelMock = $this->getModelMock('catalog/product',
            ['setStoreId', 'load', 'setSkipCheckRequiredOption']);
        $productModelMock->expects($this->once())->method('setStoreId')
            ->with($this->equalTo(73))->will($this->returnSelf());
        $productModelMock->expects($this->once())->method('load')->will($this->returnSelf());
        $productModelMock->expects($this->once())->method('setSkipCheckRequiredOption')->with($this->equalTo(true));
        return $productModelMock;
    }

    /**
     * Prepare core helper
     *
     * @return mock
     */
    private function prepareCoreHelper()
    {
        $coreHelperMock = $this->getHelperMock('core', ['copyFieldset']);
        $coreHelperMock->expects($this->once())->method('copyFieldset');
        return $coreHelperMock;
    }

    /**
     * test init from order when customer id is null
     *
     * @return void
     */
    public function testInitFromOrderWhenUserIdIsNull()
    {
        $order = $this->prepareOrder(null);

        $helperDataMock = $this->prepareHelperDataMock();
        $this->replaceByMock('helper', 'oggetto_oneClick', $helperDataMock);

        $sessionMock = $this->prepareSessionMock();
        $sessionMock->expects($this->once())->method('setCustomerId')->with($this->equalTo(false));
        $sessionMock->expects($this->once())->method('setCustomerIsGuest')->with($this->equalTo(true));
        $this->replaceByMock('singleton', 'adminhtml/session_quote', $sessionMock);

        $productModelMock = $this->prepareProductModuleMock();
        $this->replaceByMock('model', 'catalog/product', $productModelMock);

        $coreHelperMock = $this->prepareCoreHelper();
        $this->replaceByMock('helper', 'core', $coreHelperMock);

        $model = new Oggetto_OneClick_Model_Order;
        $model->initFromOrder($order);
    }

    /**
     * test init from order when customer id isn't null
     *
     * @return void
     */
    public function testInitFromOrderWhenUserIdIsNotNull()
    {
        $order = $this->prepareOrder(69);

        $helperDataMock = $this->prepareHelperDataMock();
        $this->replaceByMock('helper', 'oggetto_oneClick', $helperDataMock);

        $sessionMock = $this->prepareSessionMock();
        $sessionMock->expects($this->once())->method('setCustomerId')->with($this->equalTo(69));
        $this->replaceByMock('singleton', 'adminhtml/session_quote', $sessionMock);

        $productModelMock = $this->prepareProductModuleMock();
        $this->replaceByMock('model', 'catalog/product', $productModelMock);

        $coreHelperMock = $this->prepareCoreHelper();
        $this->replaceByMock('helper', 'core', $coreHelperMock);

        $model = new Oggetto_OneClick_Model_Order;
        $model->initFromOrder($order);
    }
}
