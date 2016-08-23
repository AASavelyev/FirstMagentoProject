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
class Oggetto_Shipping_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get country, state and city current store
     *
     * @return array
     */
    public function getStoreAddressInfo()
    {
        $fromCountryId = Mage::getStoreConfig('shipping/origin/country_id');
        $countryFromName = $this->getCountryNameByCode($fromCountryId);

        $regionFromId = Mage::getStoreConfig('shipping/origin/region_id');
        $regionFromName = Mage::getModel('directory/region')->load($regionFromId)->getName();
        $cityFrom = Mage::getStoreConfig('shipping/origin/city');
        return array(
            'storeCountry' => $countryFromName,
            'storeRegion' => $regionFromName,
            'storeCity' => $cityFrom
        );
    }

    /**
     * Get country name in russian by code
     *
     * @param string $code
     * @return string
     */
    public function getCountryNameByCode($code)
    {
        $locale = new Zend_Locale('ru_RU');
        $countries = $locale->getTranslationList('Territory', $locale->getLanguage(), 2);
        return $countries[$code];
    }
}
