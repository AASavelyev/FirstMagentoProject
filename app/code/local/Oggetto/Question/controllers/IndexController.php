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
 * Index controller
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage controllers
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Question_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * index action shows question and form
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * save action saves new question form user in database
     *
     * @return void
     */
    public function saveAction()
    {
        $postData = $this->getRequest()->getPost();
        $question = Mage::getModel('oggetto_question/question');
        $question->saveQuestion($postData);
        $this->_redirect('question');
    }

    /**
     * show question
     *
     * @return void
     */
    public function showAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * delete question by id
     *
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        delete($id);
    }
}
