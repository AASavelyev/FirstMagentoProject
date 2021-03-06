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
 * Order class
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Model_Order extends Mage_Adminhtml_Model_Sales_Order_Create
{
    protected $_session;
    protected $_quote;

    /**
     * init model order
     */
    public function __construct()
    {
        $this->_session = Mage::getSingleton('adminhtml/session_quote');
    }

    /**
     * init order model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('oggetto_oneClick/Order');
    }

    /**
     * Initialize creation data from existing one click order
     *
     * @param Oggetto_OneClick_Model_OneClickOrder $order one click order
     * @return Mage_Adminhtml_Model_Sales_Order_Create
     */
    public function initFromOrder($order)
    {
        $helper = Mage::helper('oggetto_oneClick');
        $session = $this->getSession();
        $session->setCurrencyId($helper->getCurrencyCode());
        if ($order->getUserId()) {
            $session->setCustomerId($order->getUserId());
        } else {
            $session->setCustomerId(false);
        }
        $session->setStoreId($order->getStoreId());

        Mage::dispatchEvent('init_from_order_session_quote_initialized',
            array('session_quote' => $session));

        $this->initRuleData();
        $this->initFromProductId($order->getProductId());
        $quote = $this->getQuote();

        Mage::helper('core')->copyFieldset(
            'sales_copy_order',
            'to_edit',
            $order,
            $quote
        );

        Mage::dispatchEvent('sales_convert_order_to_quote', array(
            'order' => $order,
            'quote' => $quote
        ));

        if (!$order->getUserId()) {
            $quote->setCustomerIsGuest(true);
        }
        $quote->setOneClickOrderId($order->getOrderId());
        $quote->setCustomerFirstname($order->getUsername());
        $quote->save();
        return $this;
    }

    /**
     * Initialize creation data from product id
     *
     * @param int $productId product id
     * @return Mage_Sales_Model_Quote_Item | string
     */
    private function initFromProductId($productId)
    {
        $storeId = $this->getSession()->getStoreId();
        $product = Mage::getModel('catalog/product')
            ->setStoreId($storeId)
            ->load($productId);
        $product->setSkipCheckRequiredOption(true);
        $buyRequest = new Varien_Object(array());
        $buyRequest->setQty(1);
        $item = $this->getQuote()->addProduct($product, $buyRequest);
        if (is_string($item)) {
            return $item;
        }

        Mage::dispatchEvent('sales_convert_order_item_to_quote_item', array(
            'order_item' => new Varien_Object([
                'product_id' => $productId,
                'store_id' => $storeId
            ]),
            'quote_item' => $item
        ));
        return $item;
    }
}
