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
 * Category Attribute Helper
 *
 * @category   Oggetto
 * @package    Oggetto_Attribute
 * @subpackage Helper
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Attribute_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Return default attribute source model by input type
     *
     * @param string $inputType input type
     * @return string|null
     */
    public function getAttributeSourceModelByInputType($inputType)
    {
        $inputTypes = $this->getAttributeInputTypes();
        if (!empty($inputTypes[$inputType]['source_model'])) {
            return $inputTypes[$inputType]['source_model'];
        }
        return null;
    }

    /**
     * Return default attribute backend model by input type
     *
     * @param string $inputType input type
     * @return string|null
     */
    public function getAttributeBackendModelByInputType($inputType)
    {
        $inputTypes = $this->getAttributeInputTypes();
        if (!empty($inputTypes[$inputType]['backend_model'])) {
            return $inputTypes[$inputType]['backend_model'];
        }
        return null;
    }

    /**
     * Return information array of product attribute input types
     * Only a small number of settings returned, so we won't break anything in current dataflow
     * As soon as development process goes on we need to add there all possible settings
     *
     * @param string $inputType input type
     * @return array
     */
    public function getAttributeInputTypes($inputType = null)
    {
        $inputTypes = array(
            'multiselect'   => array(
                'backend_model'     => 'eav/entity_attribute_backend_array'
            ),
            'boolean'       => array(
                'source_model'      => 'eav/entity_attribute_source_boolean'
            )
        );

        if (is_null($inputType)) {
            return $inputTypes;
        } else if (isset($inputTypes[$inputType])) {
            return $inputTypes[$inputType];
        }
        return array();
    }
}
