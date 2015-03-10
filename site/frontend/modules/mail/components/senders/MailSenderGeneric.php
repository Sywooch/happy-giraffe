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
            'subject' => $this->prepareSubject($this->subject, $user),
            'templateFile' => $this->templateFile,
        ));
        Yii::app()->postman->send($message);
    }

    protected function prepareSubject($subject, $user)
    {
        $replacements = array(
            '{firstName}' => $user->first_name,
        );

        return str_replace(array_keys($replacements), array_values($replacements), $subject);
    }
}