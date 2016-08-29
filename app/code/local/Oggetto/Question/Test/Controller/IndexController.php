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
 * @subpackage controllers
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */
class Oggetto_Question_Test_Controller_IndexController extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * test saveAction
     *
     * @return void
     */
    public function testSaveAction()
    {
        $modelMock = $this->mockModel('oggetto_question/question', ['saveQuestion']);
        $modelMock->expects($this->once())->method('saveQuestion');

        $this->replaceByMock('model', 'oggetto_question/question', $modelMock);

        $this->dispatch('question/index/save');
        $this->assertRedirectToUrlContains('question');
    }
}