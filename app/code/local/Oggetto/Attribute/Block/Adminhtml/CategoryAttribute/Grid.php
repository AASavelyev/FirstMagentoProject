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
 * Category attribute grid block
 *
 * @category   Oggetto
 * @package    Oggetto_Attribute
 * @subpackage Block
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Attribute_Block_Adminhtml_CategoryAttribute_Grid
    extends Oggetto_Attribute_Block_Adminhtml_Base_BaseAttribute_Grid
{
    /**
     * Prepare category attributes grid collection object
     *
     * @return Oggetto_Attribute_Block_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('oggetto_attribute/catalogCollection')
            ->addVisibleFilter()
            ->addEntityTypeFilter(Mage_Catalog_Model_Category::ENTITY);
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }



    /**
     * Prepare product attributes grid columns
     *
     * @return Mage_Adminhtml_Block_Catalog_Product_Attribute_Grid
     */
    protected function _prepareColumns()
    {
        parent::_prepareColumns();

        $this->addColumnAfter('is_visible', array(
            'header' => $this->__('Visible'),
            'sortable' => true,
            'index' => 'is_visible_on_front',
            'type' => 'options',
            'options' => array(
                '1' => $this->__('Yes'),
                '0' => $this->__('No'),
            ),
            'align' => 'center',
        ), 'frontend_label');

        $this->addColumnAfter('is_global', array(
            'header' => $this->__('Scope'),
            'sortable' => true,
            'index' => 'is_global',
            'type' => 'options',
            'options' => array(
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE => $this->__('Store View'),
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE => $this->__('Website'),
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL => $this->__('Global'),
            ),
            'align' => 'center',
        ), 'is_visible');

        return $this;
    }
}
