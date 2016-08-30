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
 * Connect with oggetto payment api
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage Model
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Payment_Model_PaymentApi_Payment extends Mage_Core_Model_Abstract
{
    const SUCCESS_STATUS = 1;
    const ERROR_STATUS = 2;
    const PAYMENT_REPORT_URL = 'http://office.oggettoweb.com:12345/payment/standard/checkPayment';
    /**
     * check is valid request
     *
     * @param array $postData request which was sent by oggetto payment system
     * @return bool
     */
    public function checkValidRequest($postData)
    {
        if (http_response_code() == 200) {
            $order = Mage::getModel('sales/order')->load($postData['order_id']);
            if ($order != null) {
                return str_replace('.', ',', $order->getBaseGrandTotal()) == $postData['total']
                && $postData['status'] == self::SUCCESS_STATUS
                && $this->getHashFromArray($postData) == $postData['hash'];
            }
        }
        return false;
    }

    /**
     * get payment info
     *
     * @return array
     */
    public function getPaymentInfo()
    {
        $orderIncrementId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);
        Mage::getModel('oggetto_payment/invoice')->createPendingInvoice($order);

        $cartItems = $order->getAllVisibleItems();
        $items = array();
        foreach ($cartItems as $item) {
            $items[] = $item->getName();
        }

        $paymentInfo = [
            'total'              => str_replace('.', ',', $order->getBaseGrandTotal()),
            'order_id'           => $order->getEntityId(),
            'items'              => join(',', $items),
            'success_url'        => Mage::helper('oggetto_payment')->getPaymentUrl('success'),
            'error_url'          => Mage::helper('oggetto_payment')->getPaymentUrl('error'),
            'payment_report_url' => self::PAYMENT_REPORT_URL
        ];
        $paymentInfo['hash'] = $this->getHashFromArray($paymentInfo);
        return $paymentInfo;
    }

    /**
     * get hash from request
     *
     * @param array $request request
     * @return string
     */
    private function getHashFromArray($request)
    {
        $key = Mage::helper('oggetto_payment')->getSecretPaymentKey();
        ksort($request);
        $signatureArray = array();

        foreach ($request as $x => $value) {
            // check that key doesn't equal hash
            if ($x != 'hash') {
                $signatureArray[] = $x . ':' . $value;
            }
        }
        return md5(join('|', $signatureArray) . '|' . $key);
    }
}
