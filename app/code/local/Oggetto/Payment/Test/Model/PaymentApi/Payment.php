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
 * Test payment api methods
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage Text
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Payment_Test_Model_PaymentApi_Payment extends EcomDev_PHPUnit_Test_Case
{
    /**
     * test get payment info method
     *
     * @return void
     */
    public function testGetPaymentInfo()
    {
        $orderIncrementId = 42;
        $entityId = 106;
        $total = 100.67;
        $item1 = new Varien_Object();
        $item1->setName('item1');
        $item2 = new Varien_Object();
        $item2->setName('item2');
        $item3 = new Varien_Object();
        $item3->setName('item3');
        $items = new Varien_Data_Collection();
        $items->addItem($item1);
        $items->addItem($item2);
        $items->addItem($item3);

        $secretKey = 'xxxyyy';
        $successUrl = 'magento.com/payment/success';
        $errorUrl = 'magento.com/payment/error';

        $mockCheckout = $this->getModelMock('checkout/session', ['getLastRealOrderId']);
        $mockCheckout->expects($this->once())->method('getLastRealOrderId')
            ->will($this->returnValue($orderIncrementId));
        $this->replaceByMock('singleton', 'checkout/session', $mockCheckout);

        $mockOrder = $this->getModelMock('sales/order',
                    ['loadByIncrementId', 'getBaseGrandTotal', 'getEntityId', 'getAllVisibleItems']);
        $mockOrder->expects($this->once())->method('loadByIncrementId')->with($this->equalTo($orderIncrementId))
            ->will($this->returnSelf());
        $mockOrder->expects($this->once())->method('getEntityId')->will($this->returnValue($entityId));
        $mockOrder->expects($this->once())->method('getBaseGrandTotal')->will($this->returnValue($total));
        $mockOrder->expects($this->once())->method('getAllVisibleItems')->will($this->returnValue($items));
        $this->replaceByMock('model', 'sales/order', $mockOrder);

        $helperMock = $this->getHelperMock('oggetto_payment', ['getPaymentUrl', 'getSecretPaymentKey']);
        $helperMock->expects($this->once())->method('getSecretPaymentKey')->will($this->returnValue($secretKey));
        $helperMock->expects($this->at(0))->method('getPaymentUrl')->with($this->equalTo('success'))
            ->will($this->returnValue($successUrl));
        $helperMock->expects($this->at(1))->method('getPaymentUrl')->with($this->equalTo('error'))
            ->will($this->returnValue($errorUrl));
        $this->replaceByMock('helper', 'oggetto_payment', $helperMock);

        $mockInvoice = $this->getModelMock('oggetto_payment/invoice', ['createPendingInvoice']);
        $mockInvoice->expects($this->once())->method('createPendingInvoice')->will($this->returnSelf());
        $this->replaceByMock('model', 'oggetto_payment/invoice', $mockInvoice);

        $actual = Mage::getModel('oggetto_payment/paymentApi_payment')->getPaymentInfo();
        $this->assertEquals('100,67', $actual['total']);
        $this->assertEquals($entityId, $actual['order_id']);
        $this->assertEquals('item1,item2,item3', $actual['items']);
        $this->assertEquals('c2bdd3b1e075d707c90073e7320fea7f', $actual['hash']);
    }

    /**
     * test checkValidRequest method when request is successful
     *
     * @param array $postData data
     * @return void
     * @dataProvider additionProvider
     */
    public function testCheckValidRequestWhenSuccess($postData)
    {
        header('HTTP/1.0 200 OK', true, 200);
        $order = new Varien_Object();
        $order->setBaseGrandTotal(55);
        $secretKey = 'xxxyyy';

        $modelMock = $this->getModelMock('sales/order', ['load']);
        $modelMock->expects($this->once())->method('load')->with($this->equalTo($postData['order_id']))
            ->will($this->returnValue($order));
        $this->replaceByMock('model', 'sales/order', $modelMock);

        $helperMock = $this->getHelperMock('oggetto_payment', ['getSecretPaymentKey']);
        $helperMock->method('getSecretPaymentKey')->will($this->returnValue($secretKey));
        $this->replaceByMock('helper', 'oggetto_payment', $helperMock);

        $actual = Mage::getModel('oggetto_payment/paymentApi_payment')->checkValidRequest($postData);
        $expected = 55 == $postData['total'] && 1 == $postData['status']
            && '33f64b25148af6d51df8f26bccb0f37f' == $postData['hash'];
        $this->assertEquals($expected, $actual);
    }

    /**
     * test checkValidRequest method when request with error
     *
     * @param array $postData data
     * @return void
     * @dataProvider additionProvider
     */
    public function testCheckValidRequestWhenError($postData)
    {
        header('HTTP/1.0 500 Internal Server Error', true, 500);

        $actual = Mage::getModel('oggetto_payment/paymentApi_payment')->checkValidRequest($postData);
        $this->assertEquals(false, $actual);
    }

    /**
     * return array of test data
     *
     * @return array
     */
    public function additionProvider()
    {
        $result = array();
        $result[] = [[
            'order_id' => 54,
            'total' => '55',
            'status' => '1',
            'hash' => '33f64b25148af6d51df8f26bccb0f37f'
        ]];
        $result[] = [[
            'order_id' => 54,
            'total' => '55',
            'status' => '1',
            'hash' => '33f64b25148af6d51df8f26bccb9f37f'
        ]];
        $result[] = [[
            'order_id' => 54,
            'total' => '55',
            'status' => '2',
            'hash' => 'a665fe1489650ca44b031e97debe5425'
        ]];
        $result[] = [[
            'order_id' => 54,
            'total' => '56',
            'status' => '1',
            'hash' => '67339141bfe0d72b66608a75b1e0425f'
        ]];
        $result[] = [[
            'order_id' => 54,
            'total' => '56',
            'status' => '2',
            'hash' => '17a23aee3848fc2d11e63a5ae753d970'
        ]];
        return $result;
    }
}
