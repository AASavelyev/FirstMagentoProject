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
 * Test one click log model
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneCLick_Test_Model_OneClickLog extends EcomDev_PHPUnit_Test_Case
{
    /**
     * test save log
     *
     * @return void
     */
    public function testSaveLog()
    {
        $orderId = 73;

        $modelMock = $this->getModelMock('oggetto_oneClick/oneClickLog',
            ['setOrderId', 'setDate', 'setState', 'save']);
        $modelMock->expects($this->once())->method('setOrderId')
            ->with($this->equalTo($orderId))->will($this->returnSelf());
        $modelMock->expects($this->once())->method('setDate')->will($this->returnSelf());
        $modelMock->expects($this->once())->method('setState')
            ->with(Oggetto_OneClick_Model_OneClickLog::NEW_STATUS)->will($this->returnSelf());
        $modelMock->expects($this->once())->method('save');
        $modelMock->saveLog($orderId);
    }

    /**
     * test log wth comment
     *
     * @return void
     */
    public function testLog()
    {
        $orderId = 42;
        $comment = 'comment';
        $state = Oggetto_OneClick_Model_OneClickLog::REJECTED_STATUS;

        $helperMock = $this->getHelperMock('oggetto_oneClick/user', ['getAdminName']);
        $helperMock->expects($this->once())->method('getAdminName')->will($this->returnValue('admin'));
        $this->replaceByMock('helper', 'oggetto_oneClick/user', $helperMock);

        $modelMock = $this->getModelMock('oggetto_oneClick/oneClickLog',
            ['setOrderId', 'setDate', 'setState', 'setUsername', 'setComment', 'save']);
        $modelMock->expects($this->once())->method('setOrderId')
            ->with($this->equalTo($orderId))->will($this->returnSelf());
        $modelMock->expects($this->once())->method('setDate')->will($this->returnSelf());
        $modelMock->expects($this->once())->method('setState')->with($this->equalTo($state))->will($this->returnSelf());
        $modelMock->expects($this->once())->method('setUsername')
            ->with($this->equalTo('admin'))->will($this->returnSelf());
        $modelMock->expects($this->once())->method('setComment')
            ->with($this->equalTo($comment))->will($this->returnSelf());
        $modelMock->expects($this->once())->method('save');
        $modelMock->log($orderId, $comment, $state);
    }
}
