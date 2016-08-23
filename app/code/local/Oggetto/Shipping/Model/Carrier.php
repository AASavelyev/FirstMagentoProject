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
 * the Oggetto Video module to newer versions in the future.
 * If you wish to customize the Oggetto Video module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Shipping
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Question collection model
 *
 * @category   Oggetto
 * @package    Oggetto_Shipping
 * @subpackage Model
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Shipping_Model_Carrier extends Mage_Shipping_Model_Carrier_Abstract implements
    Mage_Shipping_Model_Carrier_Interface
{
    protected
    $_code = 'oggetto_shipping';

    protected $_types = ['Fast', 'Standard'];

    /**
     * Collect and get rates
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Rate_Result|bool|null
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        $result = $this->_getStandardRates($request);
        return $result;
    }

    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array(
            'standard' => 'Standard delivery',
            'express' => 'Express delivery',
        );
    }

    /**
     * Get standard rate
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Rate_Result
     */
    protected function _getStandardRates(Mage_Shipping_Model_Rate_Request $request)
    {
        $api = Mage::getModel('oggetto_shipping/api_client');
        $responce = $api->getShippingInfo(
            $request->getDestCountryId(),
            $request->getDestRegionId(),
            $request->getDestCity()
        );
        $result = Mage::getModel('shipping/rate_result');
        $types = array();

        if ($responce['status'] != 'error') {
            $types[] = array(
                'type' => 'Fast',
                'price' => $responce['prices']['fast']
            );
            $types[] = array(
                'type' => 'Standard',
                'price' => $responce['prices']['standard']
            );
            foreach ($types as $type) {
                $rate = Mage::getModel('shipping/rate_result_method');

                $rate->setCarrier($this->_code);
                $rate->setCarrierTitle($this->getConfigData('title'));
                $rate->setMethod('large');
                $rate->setMethodTitle($type['type'] . ' delivery');
                $rate->setPrice($this->_convertToUsd($type['price']));
                $rate->setCost(0);
                $result->append($rate);
            }
        }

        return $result;
    }

    /**
     * Convert price from RUB to USD
     *
     * @param double $price
     * @return double
     */
    private function _convertToUsd($price)
    {
        $baseCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
        return Mage::helper('directory')->currencyConvert($price, 'RUB', $baseCurrencyCode);
    }
}
