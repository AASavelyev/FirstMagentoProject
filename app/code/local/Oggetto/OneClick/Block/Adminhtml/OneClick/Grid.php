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
 * grid for showing one click orders
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Block_Adminhtml_OneClick_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * set default setups
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_oneClick';

        $this->setDefaultSort('date');
        $this->setDefaultDir('desc');
        parent::_construct();
    }

    /**
     * prepare one click orders collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('oggetto_oneClick/oneClickOrder')->getCollection()
            ->addStatusName();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare columns
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('order_id', array(
            'header'        => $this->__('id'),
            'align'         => 'right',
            'width'         => '20px',
            'filter_index'  => 'order_id',
            'index'         => 'order_id'
        ));

        $this->addColumn('username', array(
            'header'        => $this->__('Username'),
            'align'         => 'left',
            'filter_index'  => 'username',
            'index'         => 'username',
            'type'          => 'text',
            'truncate'      => 50,
            'escape'        => true,
        ));

        $this->addColumn('phone', array(
            'header'        => $this->__('Phone'),
            'align'         => 'left',
            'filter_index'  => 'phone',
            'index'         => 'phone',
            'type'          => 'text',
            'truncate'      => 50,
            'escape'        => true,
        ));

        $this->addColumn('product_id', array(
            'header'        => $this->__('Product'),
            'align'         => 'left',
            'filter_index'  => 'product_id',
            'index'         => 'product_id',
            'renderer'      => 'Oggetto_OneClick_Block_Adminhtml_ProductRenderer',
            'type'          => 'text',
            'truncate'      => 50,
            'escape'        => true,
        ));

        $this->addColumn('date', array(
            'header'        => $this->__('Date'),
            'align'         => 'left',
            'filter_index'  => 'date',
            'index'         => 'date',
            'type'          => 'text',
            'truncate'      => 50,
            'escape'        => true,
        ));

        $this->addColumn('stateName', array(
            'header'        => $this->__('State'),
            'filter_condition_callback'  => [$this, '_addStateNameFilter'],
            'index'         => 'stateName',
            'type'          => 'options',
            'options'       => [1 => 'New', 2 => 'Rejected', 3 => 'Handled']
        ));

        return parent::_prepareColumns();
    }

    /**
     * add filter, which check state name
     *
     * @param Oggetto_OneClick_Block_Adminhtml_OneClick_Grid $collection collection
     * @param Column                                         $column     current column
     *
     * @return Oggetto_Question_Block_Adminhtml_Question_Grid
     */
    protected function _addStateNameFilter($collection, $column)
    {
        return $collection->addStateNameFilter($column->getFilter()->getValue());
    }

    /**
     * set all rows edit url
     *
     * @param row $row current row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getOrderId()));
    }
}
