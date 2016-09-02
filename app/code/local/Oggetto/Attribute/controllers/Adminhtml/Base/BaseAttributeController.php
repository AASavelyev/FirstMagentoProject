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
 * base controller for work with attributes
 *
 * @category   Oggetto
 * @package    Oggetto_Attribute
 * @subpackage controllers
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */

class Oggetto_Attribute_Adminhtml_Base_BaseAttributeController extends Mage_Adminhtml_Controller_Action
{
    protected $_entityTypeId;
    protected $_entityType;
    protected $_entityName = 'Empty';

    /**
     * prepare action
     *
     * @return void
     */
    public function preDispatch()
    {
        parent::preDispatch();
        $this->_entityTypeId = Mage::getModel('eav/entity')->setType($this->_entityType)->getTypeId();
    }

    /**
     * init controller
     *
     * @return $this
     */
    protected function _initAction()
    {
        $this->_title($this->__($this->_entityName . ' Attribute'))
            ->_title($this->__('Attributes'))
            ->_title($this->__('Manage Attributes'));
        $this->loadLayout()
            ->_setActiveMenu('catalog/attributes')
            ->_addBreadcrumb($this->__($this->_entityName . ' Attribute'), $this->__($this->_entityName . ' Attribute'))
            ->_addBreadcrumb(
                $this->__('Manage ' . $this->_entityName . ' Attributes'),
                $this->__('Manage ' . $this->_entityName . ' Attributes'));
        return $this;
    }

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
        $this->_forward('edit');
    }

    /**
     * delete attribute
     *
     * @return void
     */
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('attribute_id')) {
            $model = Mage::getModel('catalog/resource_eav_attribute');

            $model->load($id);
            if ($model->getEntityTypeId() != $this->_entityTypeId) {
                Mage::getSingleton('adminhtml/session')->addError(
                    $this->__('This attribute cannot be deleted.'));
                $this->_redirect('*/*/');
                return;
            }

            try {
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    $this->__('The attribute has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('attribute_id' => $this->getRequest()->getParam('attribute_id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            $this->__('Unable to find an attribute to delete.'));
        $this->_redirect('*/*/');
    }

    /**
     * edit action
     *
     * @return void
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('attribute_id');
        $model = Mage::getModel('catalog/resource_eav_attribute')->setEntityTypeId($this->_entityTypeId);
        if ($id) {
            $model->load($id);

            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    $this->__('This attribute no longer exists'));
                $this->_redirect('*/*/');
                return;
            }

            if ($model->getEntityTypeId() != $this->_entityTypeId) {
                Mage::getSingleton('adminhtml/session')->addError(
                    $this->__('This attribute cannot be edited.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $data = Mage::getSingleton('adminhtml/session')->getAttributeData(true);
        if (! empty($data)) {
            $model->addData($data);
        }

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
     * Filter post data
     *
     * @param array $data array
     * @return array
     */
    protected function _filterPostData($data)
    {
        if ($data) {
            $helperCatalog = Mage::helper('catalog');
            foreach ($data['frontend_label'] as & $value) {
                if ($value) {
                    $value = $helperCatalog->stripTags($value);
                }
            }

            if (!empty($data['option']) && !empty($data['option']['value']) && is_array($data['option']['value'])) {
                foreach ($data['option']['value'] as $key => $values) {
                    $data['option']['value'][$key] = array_map(array($helperCatalog, 'stripTags'), $values);
                }
            }
        }
        return $data;
    }

    /**
     * validate save form
     *
     * @return void
     */
    public function validateAction()
    {
        $response = new Varien_Object();
        $response->setError(false);

        $attributeCode  = $this->getRequest()->getParam('attribute_code');
        $attributeId    = $this->getRequest()->getParam('attribute_id');
        $attribute = Mage::getModel('catalog/resource_eav_attribute')
            ->loadByCode($this->_entityTypeId, $attributeCode);

        if ($attribute->getId() && !$attributeId) {
            Mage::getSingleton('adminhtml/session')->addError(
                $this->__('Attribute with the same code already exists'));
            $this->_initLayoutMessages('adminhtml/session');
            $response->setError(true);
            $response->setMessage($this->getLayout()->getMessagesBlock()->getGroupedHtml());
        }

        $this->getResponse()->setBody($response->toJson());
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
            $model = Mage::getModel('catalog/resource_eav_attribute');
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

            if (!isset($data['apply_to'])) {
                $data['apply_to'] = array();
            }

            $data = $this->_filterPostData($data);
            $model->addData($data);

            if (!$id) {
                $model->setEntityTypeId($this->_entityTypeId);
                $model->setIsUserDefined(1);
            }

            if ($this->getRequest()->getParam('set') && $this->getRequest()->getParam('group')) {
                $model->setAttributeSetId($this->getRequest()->getParam('set'));
                $model->setAttributeGroupId($this->getRequest()->getParam('group'));
            }

            try {
                $model->save();
                $session->addSuccess(
                    $this->__('The attribute has been saved.'));

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
