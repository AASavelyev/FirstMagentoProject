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
 * Base collection for work with attributes
 *
 * @category   Oggetto
 * @package    Oggetto_Attribute
 * @subpackage Model
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Attribute_Model_Resource_Base_BaseCollection extends Mage_Eav_Model_Resource_Entity_Attribute_Collection
{
    /**
     * @var $_tableName catalog | customer
     */
    protected $_tableName;

    /**
     * Resource model initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('eav/entity_attribute');
    }

    /**
     * initialize select object
     *
     * @return Mage_Catalog_Model_Resource_Product_Attribute_Collection
     */
    protected function _initSelect()
    {
        $columns = $this->getConnection()->describeTable($this->getResource()->getMainTable());
        unset($columns['attribute_id']);
        $retColumns = array();
        foreach ($columns as $labelColumn => $columnData) {
            $retColumns[$labelColumn] = $labelColumn;
            if ($columnData['DATA_TYPE'] == Varien_Db_Ddl_Table::TYPE_TEXT) {
                $retColumns[$labelColumn] = Mage::getResourceHelper('core')->castField('main_table.' . $labelColumn);
            }
        }
        $this->getSelect()
            ->from(array('main_table' => $this->getResource()->getMainTable()), $retColumns)
            ->join(
                array('additional_table' => $this->getTable($this->_tableName . '/eav_attribute')),
                'additional_table.attribute_id = main_table.attribute_id');

        return $this;
    }

    /**
     * Return array of fields to load attribute values
     *
     * @return array
     */
    protected function _getLoadDataFields()
    {
        $fields = array_merge(
            parent::_getLoadDataFields(),
            array(
                'additional_table.is_global',
                'additional_table.is_html_allowed_on_front',
                'additional_table.is_wysiwyg_enabled'
            )
        );

        return $fields;
    }

    /**
     * Specify filter by "is_visible" field
     *
     * @return Mage_Catalog_Model_Resource_Product_Attribute_Collection
     */
    public function addVisibleFilter()
    {
        return $this->addFieldToFilter('additional_table.is_visible', 1);
    }

    /**
     * Filter by entity type
     *
     * @param string $entityType entity type
     * @return Oggetto_Attribute_Model_Resource_Collection
     */
    public function addEntityTypeFilter($entityType)
    {
        $entityTypeId = (int)Mage::getModel('eav/entity')->setType($entityType)->getTypeId();
        return $this->addFieldToFilter('main_table.entity_type_id', $entityTypeId);
    }
}
