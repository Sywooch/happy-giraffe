<?php
/**
 * @author Никита
 * @date 10/03/15
 */

class MailSenderGeneric extends MailSender
{
    protected $debugMode = self::DEBUG_DEVELOPMENT;

    public $subject;
    public $templateFile;

    public function __construct($subject, $templateFile)
    {
        $this->subject = $subject;
        $this->templateFile = $templateFile;
    }

    public function process(User $user)
    {
        $message = new MailMessageGeneric($user, array(
            'subject' => $this->subject,
            'templateFile' => $this->templateFile,
        ));
        Yii::app()->postman->send($message);
    }
}