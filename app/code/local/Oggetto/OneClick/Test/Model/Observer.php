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
 * Test Observer. Event when order is checkout submit all after
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case
{
    /**
     * test observer when triggered
     *
     * @return void
     */
    public function testUpdateOrderWhenTriggered()
    {
        $quote = new Varien_Object(array());
        $quote->setOneClickOrderId(42);

        $event = new Varien_Object(array());
        $event->setQuote($quote);

        $observer = new Varien_Object(array());
        $observer->setEvent($event);

        $orderModelMock = $this->getModelMock('oggetto_oneClick/oneClickOrder', ['handleOrder']);
        $orderModelMock->expects($this->once())->method('handleOrder')->with(42);
        $this->replaceByMock('model', 'oggetto_oneClick/oneClickOrder', $orderModelMock);

        $logModelMock = $this->getModelMock('oggetto_oneClick/oneClickLog', ['log']);
        $logModelMock->expects($this->once())->method('log')->with(
            42,
            Oggetto_OneClick_Model_OneClickOrder::CREATE_ORDER_MESSAGE . 42,
            Oggetto_OneClick_Model_Status::HANDLED_STATUS);
        $this->replaceByMock('model', 'oggetto_oneClick/oneClickLog', $logModelMock);

        $model = new Oggetto_OneClick_Model_Observer;
        $model->updateOrder($observer);
    }

    /**
     * test observer when there is no any one click order id
     *
     * @return void
     */
    public function testObserverWhenThereIsNoOneClickOrderId()
    {
        $quote = new Varien_Object(array());
        $quote->setOneClickOrderId(null);

        $event = new Varien_Object(array());
        $event->setQuote($quote);

        $observer = new Varien_Object(array());
        $observer->setEvent($event);

        $orderModelMock = $this->getModelMock('oggetto_oneClick/oneClickOrder', ['handleOrder']);
        $orderModelMock->expects($this->never())->method('handleOrder');
        $this->replaceByMock('model', 'oggetto_oneClick/oneClickOrder', $orderModelMock);

        $logModelMock = $this->getModelMock('oggetto_oneClick/oneClickLog', ['log']);
        $logModelMock->expects($this->never())->method('log');
        $this->replaceByMock('model', 'oggetto_oneClick/oneClickLog', $logModelMock);

        $model = new Oggetto_OneClick_Model_Observer;
        $model->updateOrder($observer);
    }
}
