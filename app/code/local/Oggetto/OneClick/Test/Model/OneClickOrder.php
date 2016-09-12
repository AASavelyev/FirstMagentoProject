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
 * Test one click order model
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Test_Model_OneClickOrder extends EcomDev_PHPUnit_Test_Case
{
    /**
     * test save order
     *
     * @return void
     */
    public function testSaveOrder()
    {
        $data = [];
        $helperMock = $this->getHelperMock('oggetto_oneClick', ['getStoreId']);
        $helperMock->expects($this->once())->method('getStoreId')->will($this->returnValue(42));
        $this->replaceByMock('helper', 'oggetto_oneClick', $helperMock);

        $modelMock = $this->getModelMock('oggetto_oneClick/oneClickOrder',
            ['setData', 'setDate', 'setState', 'setStoreId', 'save']);
        $modelMock->expects($this->once())->method('setData')->with($this->equalTo($data))->will($this->returnSelf());
        $modelMock->expects($this->once())->method('setDate')->will($this->returnSelf());
        $modelMock->expects($this->once())->method('setState')
            ->with(Oggetto_OneClick_Model_Status::NEW_STATUS)->will($this->returnSelf());
        $modelMock->expects($this->once())->method('setStoreId')->with($this->equalTo(42))->will($this->returnSelf());
        $modelMock->expects($this->once())->method('save');
        $modelMock->saveOrder($data);
    }

    /**
     * test cancel order
     *
     * @return void
     */
    public function testCancelOrder()
    {
        $id = 73;
        $modelMock = $this->getModelMock('oggetto_oneClick/oneClickOrder', ['load', 'setState', 'save']);
        $modelMock->expects($this->once())->method('load')->with($this->equalTo($id))->will($this->returnSelf());
        $modelMock->expects($this->once())->method('setState')
            ->with($this->equalTo(Oggetto_OneClick_Model_Status::REJECTED_STATUS))
            ->will($this->returnSelf());
        $modelMock->expects($this->once())->method('save');

        $modelMock->cancelOrder($id);
    }

    /**
     * test handle order
     *
     * @return void
     */
    public function testHandleOrder()
    {
        $id = 73;
        $modelMock = $this->getModelMock('oggetto_oneClick/oneClickOrder', ['load', 'setState', 'save']);
        $modelMock->expects($this->once())->method('load')->with($this->equalTo($id))->will($this->returnSelf());
        $modelMock->expects($this->once())->method('setState')
            ->with($this->equalTo(Oggetto_OneClick_Model_Status::HANDLED_STATUS))
            ->will($this->returnSelf());
        $modelMock->expects($this->once())->method('save');

        $modelMock->handleOrder($id);
    }
}
