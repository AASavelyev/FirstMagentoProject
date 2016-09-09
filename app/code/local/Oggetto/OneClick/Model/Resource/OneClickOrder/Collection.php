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
 * One click order collection
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Model_Resource_OneClickOrder_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * init collection of one click orders
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('oggetto_oneClick/oneClickOrder');
    }

    /**
     * add new field - is_answered to question
     *
     * @return Oggetto_Question_Model_Resource_Question_Collection
     */
    public function addStatusName()
    {
        $this->getSelect()
            ->columns(new Zend_Db_Expr(
                "CASE state WHEN 1 THEN 'New' WHEN 2 THEN 'Rejected' WHEN 3 THEN 'Handled' END as stateName"));
        return $this;
    }

    /**
     * filter by state name
     *
     * @param string $value value of state
     * @return Oggetto_Question_Model_Resource_Question_Collection
     */
    public function addStateNameFilter($value)
    {
        $this->getSelect()->where('main_table.state = ?', $value);

        return $this;
    }
}
