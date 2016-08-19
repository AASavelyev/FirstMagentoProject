<?php

class Magentotutorial_Helloworld_MessagesController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $msg = $this->getRequest()->getParams()["msg"];
        echo $msg;
    }

    public function goodbyeAction()
    {
        echo 'Another Goodbye';
    }
}