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
class Oggetto_Question_Model_Question extends Mage_Core_Model_Abstract
{
    const NOTICE_WHEN_ANSWER = 1;
    const IGNORE_ANSWER = 0;
    /**
     * init model question
     *
     * @return Oggetto_Question_Model_Question
     */
    protected function _construct()
    {
        $this->_init('oggetto_question/question');
    }

    /**
     * save question which post user
     *
     * @param array $postData
     * @return void
     */
    public function saveQuestion($postData)
    {
        $this->setData($postData)
            ->setDate(date('Y-m-d H:i:s'))
            ->save();

        $this->_sendEmailAboutQuestion($postData, Mage::getStoreConfig('trans_email/ident_support/email'),
            Mage::getStoreConfig('trans_email/ident_support/name'));
    }

    /**
     * send email when user asks
     *
     * @param array  $emailTemplateVariables
     * @param string $email
     * @param string $name
     * @return void
     */
    private function _sendEmailAboutQuestion($emailTemplateVariables, $email, $name)
    {
        $emailTemplate = Mage::getModel('core/email_template')->loadDefault('custom_email_admin_template');

        $emailTemplate->getProcessedTemplate();
        $this->_sendEmail($emailTemplate, $emailTemplateVariables, [
            'subject' => 'Notice about question',
            'email' => $email,
            'name' => $name
        ]);
    }

    /**
     * send email when noticeWhenAnswer is 0
     *
     * @param Question $question
     * @return void
     */
    public function sendNoticedEmail($question)
    {
        if ($this->_isNoticed($question)) {
            $emailTemplate = Mage::getModel('oggetto_question/email_template')->loadDefault('custom_email_template');

            $emailTemplateVariables = array();
            $emailTemplateVariables['question'] = $question->getQuestion();
            $emailTemplateVariables['answer'] = $question->getAnswer();
            $emailTemplateVariables['url'] = Mage::getUrl('question/index/show', ['id' => $question->getQuestionId()]);

            $this->_sendEmail($emailTemplate, $emailTemplateVariables, [
                'subject' => 'Notice about answer',
                'email' => $question->getEmail(),
                'name' => $question->getName()
            ]);
            $question->setNoticeWhenAnswer(self::IGNORE_ANSWER)->save();
        }
    }

    /**
     * send email with using template
     *
     * @param EmailTemplate $emailTemplate
     * @param array         $emailTemplateVariables
     * @param array         $emailToInfo
     * @return void
     */
    private function _sendEmail($emailTemplate, $emailTemplateVariables, $emailToInfo)
    {
        $emailTemplate->getProcessedTemplate($emailTemplateVariables);
        $emailTemplate
            ->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email'))
            ->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name'))
            ->setTemplateSubject($emailToInfo['subject']);
        $emailTemplate->send($emailToInfo['email'], $emailToInfo['name'], $emailTemplateVariables);
    }

    /**
     * check if question is noticed when admin answers
     *
     * @param Question $question
     * @return bool
     */
    private function _isNoticed($question)
    {
        return $question->getNoticeWhenAnswer() == self::NOTICE_WHEN_ANSWER;
    }
}
