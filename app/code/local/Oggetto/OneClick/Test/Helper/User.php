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
 * test user helper
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Test_Helper_User extends EcomDev_PHPUnit_Test_Case
{
    /**
     * test get user info when user is anonymous
     *
     * @return void
     */
    public function testGetUserInfoWhenUserIsAnonymous()
    {
        $customerMock = $this->getModelMock('customer/session', ['isLoggedIn']);
        $customerMock->expects($this->once())->method('isLoggedIn')->will($this->returnValue(null));
        $this->replaceByMock('singleton', 'customer/session', $customerMock);

        $helper = new Oggetto_OneClick_Helper_User;
        $this->assertEquals($helper->getUserInfo(), null);
    }

    /**
     * test get user info when user is logged
     *
     * @return void
     */
    public function testGetUserInfoWhenUserIsLogged()
    {
        $user = new Varien_Object;
        $user->setName('name');
        $user->setPhone('89889763198');
        $user->setEntityId(42);

        $customerMock = $this->getModelMock('customer/session', ['isLoggedIn', 'getCustomer']);
        $customerMock->expects($this->once())->method('isLoggedIn')->will($this->returnValue(true));
        $customerMock->expects($this->once())->method('getCustomer')->will($this->returnValue($user));
        $this->replaceByMock('singleton', 'customer/session', $customerMock);

        $helper = new Oggetto_OneClick_Helper_User;
        $this->assertEquals($helper->getUserInfo(), [
            'username' => 'name',
            'phone' => '89889763198',
            'user_id' => 42
        ]);
    }
}
