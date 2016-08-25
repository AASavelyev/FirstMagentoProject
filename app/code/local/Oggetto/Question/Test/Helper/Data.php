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
 * the Oggetto Question module to newer versions in the future.
 * If you wish to customize the Oggetto Question module for your needs
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
 * @subpackage Test
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */

class Oggetto_Question_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Test isEnabled
     *
     * @return void
     */
    public function testIsEnabled()
    {
        $emailToInfo = array(
            'subject' => 'subject',
            'email'   => 'email',
            'name'    => 'name'
        );
        $emailTemplateVariables = array();

        $emailTemplateMock = $this->getMock('EmailTemplate',
            ['getProcessedTemplate', 'setSenderEmail', 'setSenderName', 'setTemplateSubject', 'send']);
        $emailTemplateMock->expects($this->once())->method('getProcessedTemplate')
            ->with($emailTemplateVariables)->will($this->returnSelf());
        $emailTemplateMock->expects($this->once())->method('setSenderEmail')->will($this->returnSelf());
        $emailTemplateMock->expects($this->once())->method('setSenderName')->will($this->returnSelf());
        $emailTemplateMock->expects($this->once())->method('setTemplateSubject')
            ->with($this->equalTo($emailToInfo['subject']))->will($this->returnSelf());
        $emailTemplateMock->expects($this->once())->method('send')
            ->with($emailToInfo['email'], $emailToInfo['name'], $emailTemplateVariables)->will($this->returnSelf());

        $helper = Mage::helper('oggetto_question');
        $helper->sendEmail($emailTemplateMock, $emailTemplateVariables, $emailToInfo);
    }
}
