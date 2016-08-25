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
 * the Oggetto Video module to newer versions in the future.
 * If you wish to customize the Oggetto Video module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Question controller
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage controllers
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Question_Adminhtml_QuestionController extends Mage_Adminhtml_Controller_Action
{
    /**
     * index action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * new action
     *
     * @return void
     */
    public function newAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * edit action
     *
     * @return void
     */
    public function editAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * delete action
     *
     * @return void
     */
    public function deleteAction()
    {
        try {
            $id = $this->getRequest()->getParam('id');
            Mage::getModel('oggetto_question/question')->setQuestionId($id)->delete();
        } catch (Exception $e) {
            Mage::logException($e);
        }
        $this->_redirect('/question/index');
    }

    /**
     * save action
     *
     * @return void
     */
    public function saveAction()
    {
        try {
            $postData = $this->getRequest()->getPost();
            $question = Mage::getModel('oggetto_question/question');
            $question->setData($postData);
            if ($question->getNoticeWhenAnswer() == Oggetto_Question_Model_Question::NOTICE_WHEN_ANSWER) {
                $question->sendNoticedEmail()->setNoticeWhenAnswer(Oggetto_Question_Model_Question::IGNORE_ANSWER);
            }
            $question->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }

        $this->_redirect('/question/index');
    }

    /**
     * grid action
     *
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('oggetto_question/adminhtml_question_grid')->toHtml()
        );
    }

    /**
     * delete selected question in admin page
     *
     * @return void
     */
    public function massDeleteAction()
    {
        try {
            $ids = $this->getRequest()->getParam("question_id");
            foreach ($ids as $id) {
                Mage::getModel('oggetto_question/question')->setQuestionId($id)->delete();
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }

        $this->_redirect('/question/index');
    }
}
