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
 * Helper for work with current user
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Helper_User extends Mage_Core_Helper_Abstract
{
    /**
     * Get info about current user
     *
     * @return array | null
     */
    public function getUserInfo()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $user = Mage::getSingleton('customer/session')->getCustomer();

            return [
                'username' => $user->getName(),
                'phone' => $user->getPhone(),
                'user_id' => $user->getEntityId()
            ];
        }
        return null;
    }

    /**
     * Get current admin Name
     *
     * @return string
     */
    public function getAdminName()
    {
        $user = Mage::getSingleton('admin/session')->getUser();
        return $user->getFirstname() . ' ' . $user->getLastname();
    }
}
