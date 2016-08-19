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
 * Edit block from
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage block
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Question_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * prepare form for edit
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'oggetto_question';
        $this->_mode = 'edit';
        $this->_controller = 'adminhtml';

        $questionId = (int)$this->getRequest()->getParam($this->_objectId);
        $question = Mage::getModel('oggetto_question/question')->load($questionId);
        Mage::register('current_question', $question);
    }

    /**
     * get header text for edit form
     *
     * @return Mage_Core_Helper_Abstract
     */
    public function getHeaderText()
    {
        $question = Mage::registry('current_question');
        if ($question->getId()) {
            return Mage::helper('oggetto_question')->__("Edit question '%s'", $this->escapeHtml($question->getName()));
        } else {
            return Mage::helper('oggetto_question')->__("Add new Question");
        }
    }
}
