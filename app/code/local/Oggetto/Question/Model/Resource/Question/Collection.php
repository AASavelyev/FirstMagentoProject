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
 * the Oggetto Video module to newer versions in the future.
 * If you wish to customize the Oggetto Video module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Question collection model
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage Model
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Question_Model_Resource_Question_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * init collection of question
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('oggetto_question/question');
    }

    /**
     * filter collection by have answer
     *
     * @return Oggetto_Question_Model_Resource_Question_Collection
     */
    public function addAnswerFilter()
    {
        $this->addFieldToFilter('answer', array("notnull" => true));
        return $this;
    }

    /**
     * order question by date descending
     *
     * @return Oggetto_Question_Model_Resource_Question_Collection
     */
    public function orderByDate()
    {
        $this->setOrder('date', 'DESC');
        return $this;
    }

    /**
     * add new field - is_answered to question
     *
     * @return Oggetto_Question_Model_Resource_Question_Collection
     */
    public function addIsAnsweredToSelect()
    {
        $this->getSelect()->columns('if(answer is null, 0, 1) as is_answered');
        return $this;
    }

    /**
     * add isAnswered field to collection of questions
     *
     * @param string $value value of answer
     * @return Oggetto_Question_Model_Resource_Question_Collection
     */
    public function addIsAnsweredFilter($value)
    {
        $this->getSelect()->where(
            $this->getConnection()->quoteInto('if(answer is null, 0, 1) = ?', $value)
        );
        return $this;
    }
}
