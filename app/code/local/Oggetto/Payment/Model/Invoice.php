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
 * Invoice model for working with invoices
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage Model
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Payment_Model_Invoice extends Mage_Core_Model_Abstract
{
    /**
     * Create pending invoice by order
     *
     * @param Order $order order, which is used for create invoice
     * @return void
     */
    public function createPendingInvoice($order)
    {
        try {
            if (!$order->canInvoice()) {
                Mage::throwException(Mage::helper('core')->__('Cannot create an invoice.'));
            }

            $invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice();

            if (!$invoice->getTotalQty()) {
                Mage::throwException(Mage::helper('core')->__('Cannot create an invoice without products.'));
            }
            // Options: CAPTURE_ONLINE / CAPTURE_OFFLINE / NOT_CAPTURE
            $invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_OFFLINE);
            $invoice->register();
            $invoice->getOrder()->setCustomerNoteNotify(false);
            $invoice->getOrder()->setIsInProcess(true);
            // Options: STATE_OPEN / STATE_PAID / STATE_CANCELED
            $invoice->setState(Mage_Sales_Model_Order_Invoice::STATE_OPEN);
            $transactionSave = Mage::getModel('core/resource_transaction')
                ->addObject($invoice)
                ->addObject($invoice->getOrder());
            $transactionSave->save();
        } catch (Mage_Core_Exception $e) {
            $order->addStatusHistoryComment($e->getMessage(), false);
            $order->save();
        }
    }

    /**
     * Update invoice's status by order
     *
     * @param int $orderId order
     * @param int $status  invoice's status
     * @return void
     */
    public function setInvoiceStatus($orderId, $status)
    {
        $order = Mage::getModel('sales/order')->load($orderId);
        $invoiceModel = Mage::getModel('sales/order_invoice');
        $invoice = $invoiceModel->load($order->getInvoiceCollection()->getAllIds()[0]);
        $invoice->setState($status)->save();
    }
}
