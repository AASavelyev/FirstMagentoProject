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
 * the Oggetto Payment module to newer versions in the future.
 * If you wish to customize the Oggetto Payment module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Test invoice model
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage Test
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Payment_Test_Model_Invoice extends EcomDev_PHPUnit_Test_Case
{
    /**
     * test set invoice status
     *
     * @return void
     */
    public function testSetInvoiceStatus()
    {
        $orderId = 42;
        $state = 4;

        $orderMock = $this->getModelMock('sales/order', ['load', 'getInvoiceCollection', 'getAllIds']);
        $orderMock->expects($this->once())->method('load')->with($this->equalTo($orderId))->will($this->returnSelf());
        $orderMock->expects($this->once())->method('getInvoiceCollection')->will($this->returnSelf());
        $orderMock->expects($this->once())->method('getAllIds')->will($this->returnSelf());
        $this->replaceByMock('model', 'sales/order', $orderMock);

        $invoiceMock = $this->getModelMock('sales/order_invoice', ['load', 'setState', 'save']);
        $invoiceMock->expects($this->once())->method('load')->will($this->returnSelf());
        $invoiceMock->expects($this->once())->method('setState')->with($this->equalTo($state))
            ->will($this->returnSelf());
        $invoiceMock->expects($this->once())->method('save')->will($this->returnSelf());
        $this->replaceByMock('model', 'sales/order_invoice', $invoiceMock);

        Mage::getModel('oggetto_payment/invoice')->setInvoiceStatus($orderId, $state);
    }

    /**
     * test creating pending invoice
     *
     * @return void
     */
    public function testCreatePendingInvoice()
    {
        $orderMock = $this->getMockBuilder(Mage_Sales_Model_Order::class)->setMethods(['canInvoice'])->getMock();
        $orderMock->expects($this->once())->method('canInvoice')->will($this->returnValue(true));

        $invoiceMock = $this->getMockBuilder(Mage_Core_Model_Abstract::class)
            ->setMethods(['getTotalQty', 'setRequestedCaptureCase', 'register',
                          'getOrder', 'setCustomerNoteNotify', 'setIsInProcess', 'setState'])->getMock();
        $modelMock = $this->getModelMock('sales/service_order', ['prepareInvoice'], false, [$orderMock]);
        $modelMock->expects($this->once())->method('prepareInvoice')->will($this->returnValue($invoiceMock));
        $invoiceMock->expects($this->once())->method('getTotalQty')->will($this->returnValue(3));
        $invoiceMock->expects($this->once())->method('setRequestedCaptureCase')
            ->with($this->equalTo(Mage_Sales_Model_Order_Invoice::CAPTURE_OFFLINE));
        $invoiceMock->expects($this->once())->method('register');
        $invoiceMock->method('getOrder')->will($this->returnSelf());
        $invoiceMock->expects($this->once())->method('setCustomerNoteNotify')->with($this->equalTo(false));
        $invoiceMock->expects($this->once())->method('setIsInProcess')->with($this->equalTo(true));
        $invoiceMock->expects($this->once())->method('setState')
            ->with($this->equalTo(Mage_Sales_Model_Order_Invoice::STATE_OPEN));
        $this->replaceByMock('model', 'sales/service_order', $modelMock);

        $transactionMock = $this->getModelMock('core/resource_transaction', ['addObject', 'save']);
        $transactionMock->expects($this->any())->method('addObject')->will($this->returnSelf());
        $transactionMock->expects($this->once())->method('save');
        $this->replaceByMock('model', 'core/resource_transaction', $transactionMock);

        Mage::getModel('oggetto_payment/invoice')->createPendingInvoice($orderMock);
    }
}
