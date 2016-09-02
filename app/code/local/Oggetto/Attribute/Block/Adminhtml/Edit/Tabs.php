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
 * edit tabs
 *
 * @category   Oggetto
 * @package    Oggetto_Attribute
 * @subpackage Block
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Attribute_Block_Adminhtml_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * init tabs
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('product_attribute_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Attribute Information'));
    }

    /**
     * prepare main and labels tabs
     *
     * @return Mage_Core_Block_Abstract
     * @throws Exception
     */
    protected function _beforeToHtml()
    {
        $this->addTab('main', array(
            'label'     => $this->__('Properties'),
            'title'     => $this->__('Properties'),
            'content'   => $this->getLayout()
                ->createBlock('oggetto_attribute/adminhtml_edit_tab_main')->toHtml(),
            'active'    => true
        ));

        $this->addTab('labels', array(
            'label'     => $this->__('Manage Label / Options'),
            'title'     => $this->__('Manage Label / Options'),
            'content'   => $this->getLayout()
                ->createBlock('oggetto_attribute/adminhtml_edit_tab_options')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}