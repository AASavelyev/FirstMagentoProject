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
 * Test index controller
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Test_Controller_IndexController extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * test save action when user is Anonymous
     *
     * @return void
     */
    public function testSaveActionWhenUserIsAnonymous()
    {
        $postData = [
            'phone' => '89883483627',
            'username' => 'Anonymous'
        ];
        $this->getRequest()->setPost($postData);
        $orderId = 42;

        $helperMock = $this->mockHelper('oggetto_oneClick/user', ['getUserInfo']);
        $helperMock->expects($this->once())->method('getUserInfo')->willReturn(null);
        $this->replaceByMock('helper', 'oggetto_oneClick/user', $helperMock);

        $orderModel = $this->mockModel('oggetto_oneClick/oneClickOrder', ['saveOrder', 'getOrderId']);
        $orderModel->expects($this->once())->method('saveOrder')->with($postData);
        $orderModel->expects($this->once())->method('getOrderId')->willReturn($orderId);
        $this->replaceByMock('model', 'oggetto_oneClick/oneClickOrder', $orderModel);

        $logModel = $this->mockModel('oggetto_oneClick/oneClickLog', ['saveLog']);
        $logModel->expects($this->once())->method('saveLog')->with($this->equalTo($orderId));
        $this->replaceByMock('model', 'oggetto_oneClick/oneClickLog', $logModel);
        $this->dispatch('oneclick/index/save/');
    }

    /**
     * test save action when user is logged in
     *
     * @return void
     */
    public function testSaveActionWhenUserIsLoggedIn()
    {
        $postData = [
            'phone' => '89883483627',
            'username' => 'Anonymous'
        ];
        $this->getRequest()->setPost($postData);
        $orderId = 42;
        $user = [
            'phone' => '89886482081',
            'username' => 'LoggedIn',
            'user_id' => 4242
        ];

        $helperMock = $this->mockHelper('oggetto_oneClick/user', ['getUserInfo']);
        $helperMock->expects($this->once())->method('getUserInfo')->willReturn($user);
        $this->replaceByMock('helper', 'oggetto_oneClick/user', $helperMock);

        $orderModel = $this->mockModel('oggetto_oneClick/oneClickOrder', ['saveOrder', 'getOrderId']);
        $orderModel->expects($this->once())->method('saveOrder')->with($user);
        $orderModel->expects($this->once())->method('getOrderId')->willReturn($orderId);
        $this->replaceByMock('model', 'oggetto_oneClick/oneClickOrder', $orderModel);

        $logModel = $this->mockModel('oggetto_oneClick/oneClickLog', ['saveLog']);
        $logModel->expects($this->once())->method('saveLog')->with($this->equalTo($orderId));
        $this->replaceByMock('model', 'oggetto_oneClick/oneClickLog', $logModel);
        $this->dispatch('oneclick/index/save/');
    }
}
