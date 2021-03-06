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
 * block for question
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage block
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Question_Block_Adminhtml_Question extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * prepare form for adding new question
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->_addButtonLabel = Mage::helper('oggetto_question')->__('Add New Question');

        $this->_blockGroup = 'oggetto_question';
        $this->_controller = 'adminhtml_question';
        $this->_headerText = Mage::helper('oggetto_question')->__('Question');
    }
}
