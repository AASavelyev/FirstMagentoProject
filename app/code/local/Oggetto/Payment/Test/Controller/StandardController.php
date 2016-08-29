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
 * Test standard controller
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage Test
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Payment_Test_Controller_StandardController extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * Test check payment action
     *
     * @return void
     */
    public function testCheckPaymentAction()
    {
        $postData = [
            'order_id' => 42
        ];
        $this->getRequest()->setPost($postData);
        $status = Mage_Sales_Model_Order_Invoice::STATE_PAID;

        $helperMock = $this->getHelperMock('oggetto_payment', ['checkValidRequest']);
        $helperMock->expects($this->once())->method('checkValidRequest')->with($this->equalTo($postData))
            ->will($this->returnValue($status));
        $this->replaceByMock('helper', 'oggetto_payment', $helperMock);

        $modelMock = $this->getModelMock('oggetto_payment/invoice', ['setInvoiceStatus']);
        $modelMock->expects($this->once())->method('setInvoiceStatus')
            ->with(42, $status);
        $this->replaceByMock('model', 'oggetto_payment/invoice', $modelMock);
        $this->dispatch('payment/standard/checkpayment');
    }
}
