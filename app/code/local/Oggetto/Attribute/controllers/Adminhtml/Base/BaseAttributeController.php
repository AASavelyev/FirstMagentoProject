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
     * redirect if attribute no longer exists
     *
     * @param int $id attribute id
     * @return bool
     */
    protected function redirectIfNoExists($id)
    {
        if (!$id) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('This attribute no longer exists'));
            $this->_redirect('*/*/');
            return false;
        }
        return true;
    }

    /**
     * redirect if attribute code isn't valid
     *
     * @param string $attributeCode attribute code
     * @param int    $id            attribute id
     * @return bool
     */
    protected function redirectIfAttributeNoValid($attributeCode, $id)
    {
        $session = Mage::getSingleton('adminhtml/session');
        $validatorAttrCode = new Zend_Validate_Regex(array('pattern' => '/^[a-z][a-z_0-9]{1,254}$/'));
        if (!$validatorAttrCode->isValid($attributeCode)) {
            $session->addError(
                $this->__('Attribute code is invalid. Please use only letters (a-z), numbers (0-9) or' .
                    'underscore(_) in this field, first character should be a letter.')
            );
            $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
            return false;
        }
        return true;
    }

    /**
     * redirect if frontend input isn't valid
     *
     * @param string $frontendInput attribute code
     * @param int    $id            attribute id
     * @return bool
     */
    protected function redirectIfInputNoValid($frontendInput, $id)
    {
        $session = Mage::getSingleton('adminhtml/session');
        $validatorInputType = Mage::getModel('eav/adminhtml_system_config_source_inputtype_validator');
        if (!$validatorInputType->isValid($frontendInput)) {
            foreach ($validatorInputType->getMessages() as $message) {
                $session->addError($message);
            }
            $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
            return false;
        }
        return true;
    }
}
