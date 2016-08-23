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
 * the Oggetto Shipping module to newer versions in the future.
 * If you wish to customize the Oggetto Shipping module for your needs
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
class Oggetto_Shipping_Model_Api_Client
{
    /**
     * Http Client
     *
     * @var Zend_Http_Client
     */
    protected $_httpClient;

    /**
     * URL to Oggetto Shipping API
     */
    const API_URL = 'http://new.oggy.co/shipping/api/rest.php';

    /**
     * Get Zend_Http_Client
     *
     * @return Zend_Http_Client
     */
    protected function _getHttpClient()
    {
        if (!$this->_httpClient) {
            $this->_httpClient = new Zend_Http_Client(self::API_URL);
        }

        return $this->_httpClient;
    }

    /**
     * Make request to API
     *
     * @param array $data
     * @return SimpleXMLElement
     */
    protected function _makeRequest(array $data)
    {
        /** @var Zend_Http_Response $response */
        $response = $this->_getHttpClient()
            ->resetParameters(true)
            ->setParameterGet($data)
            ->request(Zend_Http_Client::GET);

        if (200 != $response->getStatus()) {
            Mage::throwException('Server error, response status:' . $response->getStatus());
        }

        return json_decode($response->getBody(), true);
    }


    /**
     * init model get shipping info
     *
     * @param string $countryId
     * @param string $regionId
     * @param string $city
     * @return object
     */
    public function getShippingInfo($countryId, $regionId, $city)
    {
        $locale = new Zend_Locale('ru_RU');
        $countries = $locale->getTranslationList('Territory', $locale->getLanguage(), 2);

        $countryName = $countries[$countryId];
        $regionName = Mage::getModel('directory/region')->load($regionId)->getName();

        $fromCountryId = Mage::getStoreConfig('shipping/origin/country_id');
        $countryFromName = $countries[$fromCountryId];

        $regionFromId = Mage::getStoreConfig('shipping/origin/region_id');
        $regionFromName = Mage::getModel('directory/region')->load($regionFromId)->getName();
        $cityFrom = Mage::getStoreConfig('shipping/origin/city');

        return $this->_makeRequest(
            [
                'from_country' => $countryFromName,
                'from_region'  => $regionFromName,
                'from_city'    => $cityFrom,
                'to_country'   => $countryName,
                'to_region'    => $regionName,
                'to_city'      => $city
            ]
        );
    }
}