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
 * @package    Oggetto_Questoion
 * @subpackage Model
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Question_Test_Model_Question extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Test extends core model
     *
     * @return void
     */
    public function testExtendsCoreModel()
    {
        $question = Mage::getModel('oggetto_question/question');
        $this->assertInstanceOf('Mage_Core_Model_Abstract', $question);
    }

    /**
     * Test uses question resource model
     *
     * @return void
     */
    public function testUsesQuestionResource()
    {
        $question = Mage::getModel('oggetto_question/question');
        $this->assertInstanceOf('Oggetto_Question_Model_Resource_Question', $question->getResource());
    }

    /**
     * Test saving question
     *
     * @return void
     */
    public function testSaveQuestion()
    {
        $questionData = [
            'email'            => 'foo@bar.com',
            'question'         => 'When will you implement this feature?',
            'name'             => 'John Doe',
            'noticeWhenAnswer' => true
        ];

        $question = $this->getModelMock('oggetto_question/question', ['setData', 'setDate', 'save']);
        $question->expects($this->once())->method('setData')
            ->with($this->equalTo($questionData))
            ->will($this->returnSelf());
        $question->expects($this->once())->method('setDate')
            ->will($this->returnSelf());
        $question->expects($this->once())->method('save');
        $this->replaceByMock('model', 'oggetto_question/question', $question);

        $model = Mage::getModel("oggetto_question/question");
        $model->saveQuestion($questionData);
    }

    /**
     * Test send email when field noticeWhenAnswer equals true
     *
     * @return void
     */
    public function testNoticedEmail()
    {
        $questionData = [
            'questionId'       => 123,
            'email'            => 'foo@bar.com',
            'question'         => 'When will you implement that feature?',
            'answer'           => 'soon',
            'name'             => 'John Doe',
            'noticeWhenAnswer' => 1
        ];

        $templateMock = $this->getModelMock('core/email_template', ['loadDefault']);

        $templateMock->expects($this->once())->method('loadDefault')
            ->with($this->equalTo('custom_email_template'))
            ->will($this->returnSelf());

        $helperMock = $this->getHelperMock('oggetto_question', ['getShowQuestionUrl', 'sendEmail']);
        $helperMock->expects($this->once())->method('getShowQuestionUrl')
            ->with($this->equalTo($questionData['questionId']))
            ->will($this->returnValue('http://someulr.com'));
        $helperMock->expects($this->once())->method('sendEmail');

        $questionMock = $this->getModelMock('oggetto_question/question', ['save',
            'setNoticeWhenAnswer', 'getQuestion', 'getAnswer', 'getQuestionId', 'getEmail', 'getName']);
        $questionMock->expects($this->once())->method('getQuestion')
            ->will($this->returnValue($questionData['question']));
        $questionMock->expects($this->once())->method('getAnswer')
            ->will($this->returnValue($questionData['answer']));
        $questionMock->expects($this->once())->method('getQuestionId')
            ->will($this->returnValue($questionData['questionId']));
        $questionMock->expects($this->once())->method('getEmail')
            ->will($this->returnValue($questionData['email']));
        $questionMock->expects($this->once())->method('getName')
            ->will($this->returnValue($questionData['name']));

        $this->replaceByMock('model', 'oggetto_question/question', $questionMock);
        $this->replaceByMock('model', 'core/email_template', $templateMock);
        $this->replaceByMock('helper', 'oggetto_question', $helperMock);

        $model = Mage::getModel("oggetto_question/question");
        $model->setData($questionData);
        $model->sendNoticedEmail();
    }
}