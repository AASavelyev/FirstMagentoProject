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
 * cancel form
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Block_Adminhtml_Delete_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare cancel form in admin
     *
     * @return void
     */
    protected function _prepareForm()
    {
        $id = Mage::registry('order_id');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('edit_oneClickOrder', array(
            'legend' => $this->__('Comment Why You Cancel This Order')
        ));

        $fieldset->addField('order_id', 'hidden', array(
            'name'      => 'order_id',
            'required'  => true,
            'value'     => $id
        ));

        $fieldset->addField('comment', 'textarea', array(
            'name'      => 'comment',
            'label'     => $this->__('Comment'),
        ));

        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/cancel'));

        $this->setForm($form);
    }
}
