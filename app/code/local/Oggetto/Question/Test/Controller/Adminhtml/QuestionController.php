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
 * Test QuestionController
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage Test
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */

class Oggetto_Question_Test_Controller_Adminhtml_QuestionController extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * test deleteAction
     *
     * @return void
     */
    public function testDeleteAction()
    {
        Mage::app()->getRequest()->setParam('id', 23);
        $modelMock = $this->mockModel('oggetto_question/question', ['setQuestionId', 'delete']);
        $modelMock->expects($this->once())->method('setQuestionId')
            ->with($this->equalTo(23))->will($this->returnSelf());
        $modelMock->expects($this->once())->method('delete')->will($this->returnSelf());

        $this->replaceByMock('model', 'oggetto_question/question', $modelMock);

        $this->dispatch('admin/question/delete');
        $this->assertRedirectToUrlContains('admin/question/index');
    }
}
