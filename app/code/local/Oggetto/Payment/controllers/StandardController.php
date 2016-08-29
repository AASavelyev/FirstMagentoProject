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
 * payment controller
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage controllers
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */

class Oggetto_Payment_StandardController extends Mage_Core_Controller_Front_Action
{
    /**
     * redirect action
     *
     * @return void
     */
    public function redirectAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * check payment
     *
     * @return void
     */
    public function checkPaymentAction()
    {
        $postData = $this->getRequest()->getPost();

        $status = Mage::helper('oggetto_payment')->checkValidRequest($postData) ?
            Mage_Sales_Model_Order_Invoice::STATE_PAID :
            Mage_Sales_Model_Order_Invoice::STATE_CANCELED;
        Mage::getModel('oggetto_payment/invoice')->setInvoiceStatus($postData['order_id'], $status);
    }

    /**
     * payment with error
     *
     * @return void
     */
    public function errorAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * success payment
     *
     * @return void
     */
    public function successAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
