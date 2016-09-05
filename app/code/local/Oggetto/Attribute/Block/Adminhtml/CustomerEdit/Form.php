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
 * Customer attribute edit form
 *
 * @category   Oggetto
 * @package    Oggetto_Attribute
 * @subpackage Block
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Attribute_Block_Adminhtml_CustomerEdit_Form extends Mage_Eav_Block_Adminhtml_Attribute_Edit_Main_Abstract
{
    /**
     * prepare form
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();
        $form = $this->getForm();
        $form->setUseContainer(true);
        $fieldset = $form->getElement('base_fieldset');
        $yesnoSource = Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray();

        $frontendInputElm = $form->getElement('frontend_input');

        $codes = Mage::getModel('oggetto_attribute/customerFormCode')->getFormCodes();

        $response = new Varien_Object();
        $response->setTypes(array());
        Mage::dispatchEvent('adminhtml_product_attribute_types', array('response' => $response));
        $_disabledTypes = array();
        $_hiddenFields = array();
        foreach ($response->getTypes() as $type) {
            if (isset($type['hide_fields'])) {
                $_hiddenFields[$type['value']] = $type['hide_fields'];
            }
            if (isset($type['disabled_types'])) {
                $_disabledTypes[$type['value']] = $type['disabled_types'];
            }
        }
        Mage::register('attribute_type_hidden_fields', $_hiddenFields);
        Mage::register('attribute_type_disabled_types', $_disabledTypes);

        $frontendInputValues = array_merge($frontendInputElm->getValues(), []);
        $frontendInputElm->setValues($frontendInputValues);

        $fieldset->addField('min_text_length', 'text', array(
            'name' => 'min_text_length',
            'label' => $this->__('Min text length'),
            'title' => $this->__('Min text length'),
            'class' => 'validate-digits',
        ));

        $fieldset->addField('max_text_length', 'text', array(
            'name' => 'max_text_length',
            'label' => $this->__('Max text length'),
            'title' => $this->__('Max text length'),
            'class' => 'validate-digits',
        ));

        $fieldset->addField('is_used_for_customer_segment', 'select', array(
            'name' => 'is_used_for_customer_segment',
            'label' => $this->__('Use in customer segment'),
            'title' => $this->__('Use in customer segment'),
            'values' => $yesnoSource,
        ));

        $fieldset->addField('input_filter', 'select', array(
            'name' => 'input_filter',
            'label' => $this->__('Input filter'),
            'title' => $this->__('Input filter'),
            'values' => $yesnoSource,
        ));

        $fieldset = $form->addFieldset('front_fieldset', array('legend' => $this->__('Frontend Properties')));

        $fieldset->addField('sort_order', 'text', array(
            'name' => 'sort_order',
            'label' => $this->__('Sort Order'),
            'title' => $this->__('Sort Order'),
            'class' => 'validate-digits',
        ));

        $fieldset->addField('used_in_forms', 'multiselect', array(
           'name' => 'usedInForms[]',
            'label' => $this->__('Used in forms'),
            'title' => $this->__('Used in forms'),
            'values' => $codes,
        ));

        $this->setForm($form);
    }
}
