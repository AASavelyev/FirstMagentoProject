<?php

class Magentotutorial_Helloworld_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function goodbyeAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function paramsAction() {
        echo '

';
        foreach($this->getRequest()->getParams() as $key=>$value) {
            echo '
Param: '.$key.'
';
            echo '
Value: '.$value.'
';
        }
        echo '

';
    }
}