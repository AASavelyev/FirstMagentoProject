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
 * Test product renderer
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Test_Block_Adminhtml_ProductRenderer extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Test product renderer column
     *
     * @return void
     */
    public function testRender()
    {
        $row = new Varien_Object;
        $row->setData(['key' => 73]);

        $helper = $this->mockHelper('oggetto_oneClick', ['getProductName', 'getProductUrl']);
        $helper->expects($this->once())->method('getProductName')->with($this->equalTo(73))
            ->will($this->returnValue('product'));
        $helper->expects($this->once())->method('getProductUrl')
            ->with($this->equalTo(73))
            ->will($this->returnValue('magento/product-777/'));
        $this->replaceByMock('helper', 'oggetto_oneClick', $helper);

        $blockMock = $this->getBlockMock('oggetto_oneClick/adminhtml_productRenderer',
            ['getColumn', 'getIndex']);
        $blockMock->expects($this->once())->method('getColumn')->will($this->returnSelf());
        $blockMock->expects($this->once())->method('getIndex')->will($this->returnValue('key'));
        $this->assertEquals($blockMock->render($row), "<a target='_blank' href='/magento/product-777/'>product</a>");
    }
}
