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
 * the Oggetto OneClick module to newer versions in the future.
 * If you wish to customize the Oggetto OneClick module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Edit one click order block
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * prepare form for edit
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'oggetto_oneClick';
        $this->_mode = 'edit';
        $this->_controller = 'adminhtml';
    }

    /**
     * get header text for edit form
     *
     * @return Mage_Core_Helper_Abstract
     */
    public function getHeaderText()
    {
        $oneClickOrder = Mage::registry('oneClick_orderInfo');
        return $this->__("Edit one click order '%s'", $this->escapeHtml($oneClickOrder->getOrderId()));
    }

    /**
     * prepare layout
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $this->_updateButton('save', 'label', $this->__('Create Order'));
        $this->_removeButton('reset');
        $this->_updateButton('delete', 'label', $this->__('Cancel'));
        return parent::_prepareLayout();
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
