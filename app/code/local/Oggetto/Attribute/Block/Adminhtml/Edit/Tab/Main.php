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
 * Main tab
 *
 * @category   Oggetto
 * @package    Oggetto_Attribute
 * @subpackage Block
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */

class Oggetto_Attribute_Block_AdminHtml_Edit_Tab_Main
    extends Mage_Eav_Block_Adminhtml_Attribute_Edit_Main_Abstract
{
    /**
     * Adding product form elements for editing attribute
     *
     * @return Mage_Adminhtml_Block_Catalog_Product_Attribute_Edit_Tab_Main
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();
        $attributeObject = $this->getAttributeObject();
        $form = $this->getForm();
        $fieldset = $form->getElement('base_fieldset');
        $frontendInputElm = $form->getElement('frontend_input');
        $additionalTypes = array(
            array(
                'value' => 'price',
                'label' => $this->__('Price')
            ),
            array(
                'value' => 'media_image',
                'label' => $this->__('Media Image')
            )
        );
        if ($attributeObject->getFrontendInput() == 'gallery') {
            $additionalTypes[] = array(
                'value' => 'gallery',
                'label' => $this->__('Gallery')
            );
        }

        $response = new Varien_Object();
        $response->setTypes(array());
        Mage::dispatchEvent('adminhtml_product_attribute_types', array('response' => $response));
        $_disabledTypes = array();
        $_hiddenFields = array();
        foreach ($response->getTypes() as $type) {
            $additionalTypes[] = $type;
            if (isset($type['hide_fields'])) {
                $_hiddenFields[$type['value']] = $type['hide_fields'];
            }
            if (isset($type['disabled_types'])) {
                $_disabledTypes[$type['value']] = $type['disabled_types'];
            }
        }
        Mage::register('attribute_type_hidden_fields', $_hiddenFields);
        Mage::register('attribute_type_disabled_types', $_disabledTypes);

        $frontendInputValues = array_merge($frontendInputElm->getValues(), $additionalTypes);
        $frontendInputElm->setValues($frontendInputValues);

        $yesnoSource = Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray();

        $scopes = array(
            Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE => $this->__('Store View'),
            Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE => $this->__('Website'),
            Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL => $this->__('Global'),
        );

        if ($attributeObject->getAttributeCode() == 'status' ||
            $attributeObject->getAttributeCode() == 'tax_class_id') {
            unset($scopes[Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE]);
        }

        $fieldset->addField('is_global', 'select', array(
            'name'   => 'is_global',
            'label'  => $this->__('Scope'),
            'title'  => $this->__('Scope'),
            'note'   => $this->__('Declare attribute value saving scope'),
            'values' => $scopes
        ), 'attribute_code');

        $fieldset->addField('apply_to', 'apply', array(
            'name'        => 'apply_to[]',
            'label'       => $this->__('Apply To'),
            'values'      => Mage_Catalog_Model_Product_Type::getOptions(),
            'mode_labels' => array(
                'all'     => $this->__('All Product Types'),
                'custom'  => $this->__('Selected Product Types')
            ),
            'required'    => true
        ), 'frontend_class');

        $fieldset->addField('is_configurable', 'select', array(
            'name' => 'is_configurable',
            'label' => $this->__('Use To Create Configurable Product'),
            'values' => $yesnoSource,
        ), 'apply_to');

        // frontend properties fieldset
        $fieldset = $form->addFieldset('front_fieldset', array('legend' => $this->__('Frontend Properties')));

        $fieldset->addField('is_searchable', 'select', array(
            'name'     => 'is_searchable',
            'label'    => $this->__('Use in Quick Search'),
            'title'    => $this->__('Use in Quick Search'),
            'values'   => $yesnoSource,
        ));

        $fieldset->addField('is_visible_in_advanced_search', 'select', array(
            'name' => 'is_visible_in_advanced_search',
            'label' => $this->__('Use in Advanced Search'),
            'title' => $this->__('Use in Advanced Search'),
            'values' => $yesnoSource,
        ));

        $fieldset->addField('is_comparable', 'select', array(
            'name' => 'is_comparable',
            'label' => $this->__('Comparable on Front-end'),
            'title' => $this->__('Comparable on Front-end'),
            'values' => $yesnoSource,
        ));

        $fieldset->addField('is_filterable', 'select', array(
            'name' => 'is_filterable',
            'label' => $this->__("Use In Layered Navigation"),
            'title' => $this->__('Can be used only with catalog input type Dropdown, Multiple Select and Price'),
            'note' => $this->__('Can be used only with catalog input type Dropdown, Multiple Select and Price'),
            'values' => array(
                array('value' => '0', 'label' => $this->__('No')),
                array('value' => '1', 'label' => $this->__('Filterable (with results)')),
                array('value' => '2', 'label' => $this->__('Filterable (no results)')),
            ),
        ));

        $fieldset->addField('is_filterable_in_search', 'select', array(
            'name' => 'is_filterable_in_search',
            'label' => $this->__("Use In Search Results Layered Navigation"),
            'title' => $this->__('Can be used only with catalog input type Dropdown, Multiple Select and Price'),
            'note' => $this->__('Can be used only with catalog input type Dropdown, Multiple Select and Price'),
            'values' => $yesnoSource,
        ));

        $fieldset->addField('is_used_for_promo_rules', 'select', array(
            'name' => 'is_used_for_promo_rules',
            'label' => $this->__('Use for Promo Rule Conditions'),
            'title' => $this->__('Use for Promo Rule Conditions'),
            'values' => $yesnoSource,
        ));

        $fieldset->addField('position', 'text', array(
            'name' => 'position',
            'label' => $this->__('Position'),
            'title' => $this->__('Position in Layered Navigation'),
            'note' => $this->__('Position of attribute in layered navigation block'),
            'class' => 'validate-digits',
        ));

        $fieldset->addField('is_wysiwyg_enabled', 'select', array(
            'name' => 'is_wysiwyg_enabled',
            'label' => $this->__('Enable WYSIWYG'),
            'title' => $this->__('Enable WYSIWYG'),
            'values' => $yesnoSource,
        ));

        $htmlAllowed = $fieldset->addField('is_html_allowed_on_front', 'select', array(
            'name' => 'is_html_allowed_on_front',
            'label' => $this->__('Allow HTML Tags on Frontend'),
            'title' => $this->__('Allow HTML Tags on Frontend'),
            'values' => $yesnoSource,
        ));
        if (!$attributeObject->getId() || $attributeObject->getIsWysiwygEnabled()) {
            $attributeObject->setIsHtmlAllowedOnFront(1);
        }

        $fieldset->addField('is_visible_on_front', 'select', array(
            'name'      => 'is_visible_on_front',
            'label'     => $this->__('Visible on Product View Page on Front-end'),
            'title'     => $this->__('Visible on Product View Page on Front-end'),
            'values'    => $yesnoSource,
        ));

        $fieldset->addField('used_in_product_listing', 'select', array(
            'name'      => 'used_in_product_listing',
            'label'     => $this->__('Used in Product Listing'),
            'title'     => $this->__('Used in Product Listing'),
            'note'      => $this->__('Depends on design theme'),
            'values'    => $yesnoSource,
        ));
        $fieldset->addField('used_for_sort_by', 'select', array(
            'name'      => 'used_for_sort_by',
            'label'     => $this->__('Used for Sorting in Product Listing'),
            'title'     => $this->__('Used for Sorting in Product Listing'),
            'note'      => $this->__('Depends on design theme'),
            'values'    => $yesnoSource,
        ));

        $form->getElement('apply_to')->setSize(5);

        if ($applyTo = $attributeObject->getApplyTo()) {
            $applyTo = is_array($applyTo) ? $applyTo : explode(',', $applyTo);
            $form->getElement('apply_to')->setValue($applyTo);
        } else {
            $form->getElement('apply_to')->addClass('no-display ignore-validate');
        }

        // define field dependencies
        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap("is_wysiwyg_enabled", 'wysiwyg_enabled')
            ->addFieldMap("is_html_allowed_on_front", 'html_allowed_on_front')
            ->addFieldMap("frontend_input", 'frontend_input_type')
            ->addFieldDependence('wysiwyg_enabled', 'frontend_input_type', 'textarea')
            ->addFieldDependence('html_allowed_on_front', 'wysiwyg_enabled', '0')
        );

        Mage::dispatchEvent('adminhtml_catalog_product_attribute_edit_prepare_form', array(
            'form'      => $form,
            'attribute' => $attributeObject
        ));

        return $this;
    }

    /**
     * Retrieve additional element types for product attributes
     *
     * @return array
     */
    protected function _getAdditionalElementTypes()
    {
        return array(
            'apply' => Mage::getConfig()->getBlockClassName('adminhtml/catalog_product_helper_form_apply'),
        );
    }
}
