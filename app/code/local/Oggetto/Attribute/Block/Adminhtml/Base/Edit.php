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
 * the Oggetto Attribute module to newer versions in the future.
 * If you wish to customize the Oggetto Attribute module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Attribute
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * edit block
 *
 * @category   Oggetto
 * @package    Oggetto_Attribute
 * @subpackage Block
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Attribute_Block_Adminhtml_Base_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * init EditBlock
     */
    public function __construct()
    {
        $this->_blockGroup = 'oggetto_attribute';
        $this->_objectId = 'attribute_id';
        $this->_controller = 'adminhtml';

        parent::__construct();
        $this->_addButton(
            'save_and_edit_button',
            array(
                'label'     => $this->__('Save and Continue Edit'),
                'onclick'   => 'saveAndContinueEdit()',
                'class'     => 'save'
            ),
            100
        );

        $this->_updateButton('save', 'label', $this->__('Save Attribute'));
        $this->_updateButton('save', 'onclick', 'saveAttribute()');

        if (! Mage::registry('entity_attribute')->getIsUserDefined()) {
            $this->_removeButton('delete');
        } else {
            $this->_updateButton('delete', 'label', $this->__('Delete Attribute'));
        }
    }

    /**
     * get header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('entity_attribute')->getId()) {
            $frontendLabel = Mage::registry('entity_attribute')->getFrontendLabel();
            if (is_array($frontendLabel)) {
                $frontendLabel = $frontendLabel[0];
            }
            return $this->__('Edit Attribute "%s"', $this->escapeHtml($frontendLabel));
        } else {
            return $this->__('New Attribute');
        }
    }

    /**
     * get validation url
     *
     * @return string
     */
    public function getValidationUrl()
    {
        return $this->getUrl('*/*/validate', array('_current' => true));
    }

    /**
     * get save url
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', array('_current' => true, 'back' => null));
    }
}
