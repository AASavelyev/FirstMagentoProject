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
 * Question collection model
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage Test
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */

class Oggetto_Question_Test_Model_Resource_Question_Collection extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Test AddAnswerFilter
     *
     * @return void
     * @loadFixture
     */
    public function testAddAnswerFilter()
    {
        $questions = Mage::getResourceModel('oggetto_question/question_collection');
        $questions = $questions->addAnswerFilter();

        $this->assertEquals(2, $questions->getSize());
        $this->assertEquals('answer', $questions->getFirstItem()->getAnswer());
    }

    /**
     * test orderByDate
     *
     * @return void
     * @loadFixture
     */
    public function testOrderByDate()
    {
        $questions = Mage::getResourceModel('oggetto_question/question_collection');
        $questions = $questions->orderByDate();

        $this->assertEquals(3, $questions->getFirstItem()->getQuestionId());
        $this->assertEquals(2, $questions->getLastItem()->getQuestionId());
    }

    /**
     * test AddIsAnsweredToSelect
     *
     * @return void
     * @loadFixture
     */
    public function testAddIsAnsweredToSelect()
    {
        $questions = Mage::getResourceModel('oggetto_question/question_collection');
        $questions = $questions->addIsAnsweredToSelect();

        $this->assertEquals(0, $questions->getFirstItem()->getIsAnswered());
        $this->assertEquals(1, $questions->getLastItem()->getIsAnswered());
    }
}