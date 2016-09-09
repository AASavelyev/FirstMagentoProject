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
 * the Oggetto ObeClick module to newer versions in the future.
 * If you wish to customize the Oggetto ObeClick module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_ObeClick
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * data helper
 *
 * @category   Oggetto
 * @package    Oggetto_ObeClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get product url by product id
     *
     * @param int $productId product id
     * @return string
     */
    public function getProductUrl($productId)
    {
        return Mage::getResourceSingleton('catalog/product')
            ->getAttributeRawValue($productId, 'url_path', Mage::app()->getStore());
    }

    /**
     * Get product name by product id
     *
     * @param int $productId product id
     * @return string
     */
    public function getProductName($productId)
    {
        return Mage::getResourceSingleton('catalog/product')
            ->getAttributeRawValue($productId, 'name', Mage::app()->getStore());
    }

    /**
     * Get product price by product id
     *
     * @param int $productId product id
     * @return double
     */
    public function getProductPrice($productId)
    {
        return Mage::getResourceSingleton('catalog/product')
            ->getAttributeRawValue($productId, 'price', Mage::app()->getStore());
    }

    /**
     * Get currency id
     *
     * @return int
     */
    public function getCurrencyCode()
    {
        return Mage::app()->getStore()->getCurrentCurrencyCode();
    }

    /**
     * Get current store id
     *
     * @return int
     */
    public function getStoreId()
    {
        return Mage::app()->getStore()->getStoreId();
    }
}
