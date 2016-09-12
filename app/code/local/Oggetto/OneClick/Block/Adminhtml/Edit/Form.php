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
 * form for edit one click orders
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Block_Adminhtml_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * get logs fro currect one click order
     *
     * @return array
     */
    public function getLogs()
    {
        $order = Mage::registry('oneClick_orderInfo');
        $logs = Mage::getResourceModel('oggetto_oneClick/oneClickLog_collection')
            ->getByOrderId($order->getOrderId());
        return $logs;
    }

    /**
     * get one click order info
     *
     * @return array
     */
    public function getOrderInfo()
    {
        return Mage::registry('oneClick_orderInfo');
    }

    /**
     * prepare edit form in admin
     *
     * @return void
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('oneClick_orderInfo');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('edit_oneClickOrder', array(
            'legend' => $this->__('One click details')
        ));

        $fieldset->addField('order_id', 'hidden', array(
            'name'      => 'order_id',
            'required'  => true
        ));

        $fieldset->addField('username', 'text', array(
            'name'      => 'username',
            'label'     => $this->__('Username'),
            'disabled'  => 'disabled',
        ));

        $fieldset->addField('phone', 'text', array(
            'name'      => 'phone',
            'label'     => $this->__('Phone'),
            'disabled'  => 'disabled',
        ));

        $fieldset->addField('product_name', 'text', array(
            'name'      => 'productName',
            'label'     => $this->__('Product Name'),
            'disabled'  => 'disabled',
        ));

        $fieldset->addField('product_price', 'text', array(
            'name'      => 'productPrice',
            'label'     => $this->__('Product Price'),
            'disabled'  => 'disabled',
        ));

        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/save'));
        $form->setValues($model->getData());

        $this->setForm($form);
    }
}
