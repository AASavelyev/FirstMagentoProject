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
 * Question block edit form
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage block
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Question_Block_Adminhtml_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare edit form in admin
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $question = Mage::registry('current_question');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('edit_question', array(
            'legend' => Mage::helper('oggetto_question')->__('Quote Details')
        ));

        if ($question->getQuestionId()) {
            $fieldset->addField('question_id', 'hidden', array(
                'name'      => 'question_id',
                'required'  => true
            ));
        }

        $fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('oggetto_question')->__('Name'),
            'maxlength' => '250',
            'required'  => true,
        ));

        $fieldset->addField('email', 'text', array(
            'name'      => 'email',
            'label'     => Mage::helper('oggetto_question')->__('Email'),
            'maxlength' => '250',
            'required'  => true,
        ));

        $fieldset->addField('question', 'textarea', array(
            'name'      => 'question',
            'label'     => Mage::helper('oggetto_question')->__('Question'),
            'style'     => 'width: 98%; height: 200px;',
            'required'  => true,
        ));

        $fieldset->addField('answer', 'textarea', array(
            'name'      => 'answer',
            'label'     => Mage::helper('oggetto_question')->__('Answer'),
            'style'     => 'width: 98%; height: 200px;',
            'required'  => true,
        ));

        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/save'));
        $form->setValues($question->getData());

        $this->setForm($form);
    }
}
