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
 * client controller for work with attributes
 *
 * @category   Oggetto
 * @package    Oggetto_Attribute
 * @subpackage controllers
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
require_once 'Base/BaseAttributeController.php';
class Oggetto_Attribute_Adminhtml_CustomerAttributeController
    extends Oggetto_Attribute_Adminhtml_Base_BaseAttributeController
{
    protected $_entityType = 'customer';
    protected $_entityName = 'Customer';

    /**
     * edit action
     *
     * @return void
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('attribute_id');
        $model = Mage::getModel('eav/entity_attribute')->setEntityTypeId($this->_entityTypeId);
        if ($id) {
            $model->load($id);

            if (!$this->redirectIfNoExists($model->getId())) {
                return;
            }
        }
        $data = Mage::getSingleton('adminhtml/session')->getAttributeData(true);
        if (! empty($data)) {
            $model->addData($data);
        }

        $validateRules = unserialize($model->getValidateRules());
        if (isset($validateRules['max_text_length'])) {
            $model->setMaxTextLength($validateRules['max_text_length']);
        }
        if (isset($validateRules['min_text_length'])) {
            $model->setMinTextLength($validateRules['min_text_length']);
        }

        $usedInForms = Mage::getSingleton('eav/config')
            ->getAttribute($this->_entityType, $model->getAttributeCode())
            ->getUsedInForms();
        $model->setData('used_in_forms', $usedInForms);

        Mage::register('entity_attribute', $model);
        $this->_initAction();
        $this->_title($id ? $model->getName() : $this->__('New Attribute'));

        $item = $id ? $this->__('Edit Attribute') :
            $this->__('New Attribute');

        $this->_addBreadcrumb($item, $item);
        $this->getLayout();
        $this->renderLayout();
    }

    /**
     * save category attribute
     *
     * @return void
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        if ($data) {
            $session = Mage::getSingleton('adminhtml/session');

            $redirectBack = $this->getRequest()->getParam('back', false);
            $model = Mage::getModel('eav/entity_attribute');
            $helper = Mage::helper('oggetto_attribute');

            $id = $this->getRequest()->getParam('attribute_id');

            if (isset($data['attribute_code'])) {
                $validatorAttrCode = new Zend_Validate_Regex(array('pattern' => '/^[a-z][a-z_0-9]{1,254}$/'));
                if (!$validatorAttrCode->isValid($data['attribute_code'])) {
                    $session->addError(
                        $this->__('Attribute code is invalid. Please use only letters (a-z), numbers (0-9) or' .
                            'underscore(_) in this field, first character should be a letter.')
                    );
                    $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                    return;
                }
            }

            if (isset($data['frontend_input'])) {
                $validatorInputType = Mage::getModel('eav/adminhtml_system_config_source_inputtype_validator');
                if (!$validatorInputType->isValid($data['frontend_input'])) {
                    foreach ($validatorInputType->getMessages() as $message) {
                        $session->addError($message);
                    }
                    $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                    return;
                }
            }

            if ($id) {
                $model->load($id);

                if (!$model->getId()) {
                    $session->addError($this->__('This Attribute no longer exists'));
                    $this->_redirect('*/*/');
                    return;
                }

                if ($model->getEntityTypeId() != $this->_entityTypeId) {
                    $session->addError($this->__('This attribute cannot be updated.'));
                    $session->setAttributeData($data);
                    $this->_redirect('*/*/');
                    return;
                }

                $data['attribute_code'] = $model->getAttributeCode();
                $data['is_user_defined'] = $model->getIsUserDefined();
                $data['frontend_input'] = $model->getFrontendInput();
            } else {
                $data['source_model'] = $helper->getAttributeSourceModelByInputType($data['frontend_input']);
                $data['backend_model'] = $helper->getAttributeBackendModelByInputType($data['frontend_input']);
            }

            if (!isset($data['is_configurable'])) {
                $data['is_configurable'] = 0;
            }
            if (!isset($data['is_filterable'])) {
                $data['is_filterable'] = 0;
            }
            if (!isset($data['is_filterable_in_search'])) {
                $data['is_filterable_in_search'] = 0;
            }

            if (is_null($model->getIsUserDefined()) || $model->getIsUserDefined() != 0) {
                $data['backend_type'] = $model->getBackendTypeByInput($data['frontend_input']);
            }

            $defaultValueField = $model->getDefaultValueByInput($data['frontend_input']);
            if ($defaultValueField) {
                $data['default_value'] = $this->getRequest()->getParam($defaultValueField);
            }

            $model->addData($data);

            if (!$id) {
                $model->setEntityTypeId($this->_entityTypeId);
                $model->setIsUserDefined(1);
            }

            if ($this->getRequest()->getParam('set') && $this->getRequest()->getParam('group')) {
                $model->setAttributeSetId($this->getRequest()->getParam('set'));
                $model->setAttributeGroupId($this->getRequest()->getParam('group'));
            }

            $validationRules = unserialize($model->getValidateRules());
            if ($data['max_text_length'] > 0) {
                $validationRules['max_text_length'] = $data['max_text_length'];
            }
            if ($data['min_text_length'] > 0 && $data['min_text_length'] <= $data['max_text_length']) {
                $validationRules['min_text_length'] = $data['min_text_length'];
            }
            $model->setValidateRules(serialize($validationRules));

            try {
                $model->save();

                if (isset($data['usedInForms'])) {
                    Mage::getModel('customer/attribute')
                        ->loadByCode($this->_entityType, $model->getAttributeCode())
                        ->setUsedInForms($data['usedInForms'])
                        ->save();
                }

                $session->addSuccess($this->__('The attribute has been saved.'));

                Mage::app()->cleanCache(array(Mage_Core_Model_Translate::CACHE_TAG));
                $session->setAttributeData(false);
                if ($redirectBack) {
                    $this->_redirect('*/*/edit', array('attribute_id' => $model->getId(), '_current' => true));
                } else {
                    $this->_redirect('*/*/', array());
                }
                return;
            } catch (Exception $e) {
                $session->addError($e->getMessage());
                $session->setAttributeData($data);
                $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
}
