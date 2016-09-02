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

        $validateRules = unserialize($model->getValidateRules());
        if (isset($validateRules['max_text_length'])) {
            $model->setMaxTextLength($validateRules['max_text_length']);
        }
        if (isset($validateRules['min_text_length'])) {
            $model->setMinTextLength($validateRules['min_text_length']);
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
}
