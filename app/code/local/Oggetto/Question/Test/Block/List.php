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
 * the Oggetto Question module to newer versions in the future.
 * If you wish to customize the Oggetto Question module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Question block list
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage block
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Question_Test_Block_List extends EcomDev_PHPUnit_Test_Case
{
    /**
     * test __construct
     *
     * @return void
     */
    public function testReturnsCollection()
    {
        $collection = $this->getResourceModelMock('oggetto_question/question_collection', ['addAnswerFilter']);
        $collection->expects($this->once())->method('addAnswerFilter')
            ->will($this->returnSelf());
        $this->replaceByMock('resource_model', 'oggetto_question/question_collection', $collection);

        $block = new Oggetto_Question_Block_List;
        $this->assertEquals($block->getCollection(), $collection);
    }

    /**
     * test getPagerHtml
     *
     * @return Oggetto_Question_Test_Block_List
     */
    public function testGetPagerHtml()
    {
        $result = 'Result';
        $block = $this->getBlockMock('oggetto_question/list', ['getChildHtml']);
        $block->expects($this->once())->method('getChildHtml')
            ->with($this->equalTo('pager'))
            ->will($this->returnValue($result));

        $block->getPagerHtml();
    }
}
