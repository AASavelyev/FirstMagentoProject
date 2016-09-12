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
 * status model
 *
 * @category   Oggetto
 * @package    Oggetto_OneClick
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_OneClick_Model_Status extends Mage_Core_Model_Abstract
{
    const NEW_STATUS = 1;
    const REJECTED_STATUS = 2;
    const HANDLED_STATUS = 3;

    /**
     * Get option text
     *
     * @param int $value value of status
     * @return string
     */
    public function getOptionText($value)
    {
        switch ($value) {
            case self::NEW_STATUS:
                return 'New';
            case self::REJECTED_STATUS:
                return 'Rejected';
            case self::HANDLED_STATUS:
                return 'Handled';
        }
    }

    /**
     * get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            self::NEW_STATUS => 'New',
            self::REJECTED_STATUS => 'Rejected',
            self::HANDLED_STATUS => 'Handled'
        ];
    }
}
