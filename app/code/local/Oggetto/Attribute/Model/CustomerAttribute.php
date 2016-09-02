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
 * the Oggetto Attribute module to newer versions in the future.
 * If you wish to customize the Oggetto Attribute module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Attribute
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Model for customer attribute
 *
 * @category   Oggetto
 * @package    Oggetto_Attribute
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Attribute_Model_CustomerAttribute extends Mage_Core_Model_Abstract
{
    /**
     * init customer attribute model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('oggetto_attribute/customerAttribute');
    }
}
