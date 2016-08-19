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
 * the Oggetto Question module to newer versions in the future.
 * If you wish to customize the Oggetto Question module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Question block grid
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage block
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Question_Block_Adminhtml_Question_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * set default setups
     *
     * @return void
     */
    protected function _construct()
    {
        $this->setId('questionGrid');
        $this->_controller = 'adminhtml_question';
        $this->setUseAjax(true);

        $this->setDefaultSort('id');
        $this->setDefaultFilter(['is_answered' => 1]);
        $this->setDefaultDir('desc');
        parent::_construct();
    }

    /**
     * prepare question collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('oggetto_question/question')->getCollection()
            ->addIsAnsweredToSelect();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * prepare mass actions for questions
     *
     * @return Oggetto_Question_Block_Adminhtml_Question_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('tax_calculation_rate_id');
        $this->getMassactionBlock()->setFormFieldName('question_id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('oggetto_question')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete', array('' => '')),
            'confirm' => Mage::helper('oggetto_question')->__('Are you sure?')
        ));

        return $this;
    }

    /**
     * prepare columns
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('question_id', array(
            'header'        => Mage::helper('oggetto_question')->__('question_id'),
            'align'         => 'right',
            'width'         => '20px',
            'filter_index'  => 'question_id',
            'index'         => 'question_id'
        ));

        $this->addColumn('email', array(
            'header'        => Mage::helper('oggetto_question')->__('email'),
            'align'         => 'left',
            'filter_index'  => 'email',
            'index'         => 'email',
            'type'          => 'text',
            'truncate'      => 50,
            'escape'        => true,
        ));

        $this->addColumn('question', array(
            'header'        => Mage::helper('oggetto_question')->__('question'),
            'align'         => 'left',
            'filter_index'  => 'question',
            'index'         => 'question',
            'type'          => 'text',
            'truncate'      => 50,
            'escape'        => true,
        ));

        $this->addColumn('answer', array(
            'header'        => Mage::helper('oggetto_question')->__('answer'),
            'align'         => 'left',
            'filter_index'  => 'answer',
            'index'         => 'answer',
            'type'          => 'text',
            'truncate'      => 50,
            'escape'        => true,
        ));

        $this->addColumn('is_answered', array(
            'header'    => Mage::helper('oggetto_question')->__('has answer'),
            'align'     => 'left',
            'type'      => 'options',
            'filter_condition_callback'  => [$this, '_addIsAnsweredFilter'],
            'index'     => 'is_answered',
            'options'   => Mage::getModel('adminhtml/system_config_source_yesno')->toArray()
        ));

        $this->addColumn('name', array(
            'header'        => Mage::helper('oggetto_question')->__('name'),
            'align'         => 'left',
            'filter_index'  => 'name',
            'index'         => 'name',
            'type'          => 'text',
            'truncate'      => 50,
            'escape'        => true,
        ));

        $this->addColumn('action', array(
            'header'    => Mage::helper('oggetto_question')->__('Action'),
            'width'     => '50px',
            'type'      => 'action',
            'getter'     => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('oggetto_question')->__('Edit'),
                    'url'     => array(
                    'base'    => '*/*/edit',
                    ),
                    'field'   => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'id',
        ));

        return parent::_prepareColumns();
    }

    /**
     * get url for rows in grid
     *
     * @param Question $question
     *
     * @return  string
     */
    public function getRowUrl($question)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $question->getId(),
        ));
    }

    /**
     * get url for grid
     *
     * @return  string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    /**
     * add filter, which check if question has answer
     *
     * @param Oggetto_Question_Block_Adminhtml_Question_Grid $collection
     * @param Column                                         $column
     *
     * @return Oggetto_Question_Block_Adminhtml_Question_Grid
     */
    protected function _addIsAnsweredFilter($collection, $column)
    {
        return $collection->addIsAnsweredFilter($column->getFilter()->getValue());
    }
}
