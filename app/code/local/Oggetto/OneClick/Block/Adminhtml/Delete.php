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
 * block for cancel one click order
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Block_Adminhtml_Delete extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * prepare form for cancel
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'oggetto_oneClick';
        $this->_mode = 'delete';
        $this->_controller = 'adminhtml';
    }

    /**
     * prepare layout
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $this->_removeButton('delete');
        $this->_removeButton('reset');

        return parent::_prepareLayout();
    }

    /**
     * get current one click order id
     *
     * @return int
     */
    public function getOneClickOrderId()
    {
        return Mage::registry('order_id');
    }
}
