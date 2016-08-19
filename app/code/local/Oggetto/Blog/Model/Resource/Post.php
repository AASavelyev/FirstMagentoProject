<?php

class Oggetto_Blog_Model_Resource_Product extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('oggetto_blog/post', 'entity_id');
    }
}
