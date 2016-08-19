<?php

class Oggetto_Blog_Model_Product extends Mage_Catalog_Model_Abstract
{
    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('oggetto_blog/post');
    }
}
