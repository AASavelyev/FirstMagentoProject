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
 * the Oggetto OneCLick module to newer versions in the future.
 * If you wish to customize the Oggetto OneCLick module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_OneCLick
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Block for work with one click order in admin panel
 *
 * @category   Oggetto
 * @package    Oggetto_OneCLick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Block_Adminhtml_OneClickOrder extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * prepare form for showing oneClick orders
     *
     */
    public function __construct()
    {
        $this->_blockGroup = 'oggetto_oneClick';
        $this->_controller = 'adminhtml_oneClick';
        $this->_headerText = $this->__('One click orders');
        parent::__construct();
        $this->_removeButton('add');
    }
}
