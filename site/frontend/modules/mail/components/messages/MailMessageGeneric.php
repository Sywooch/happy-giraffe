<?php
/**
 * @author Никита
 * @date 10/03/15
 */

class MailMessageGeneric extends MailMessage
{
    public $subject;
    public $templateFile;

    public function getSubject()
    {
        return $this->subject;
    }

    protected function getTemplateFile()
    {
        return 'generic/' . $this->templateFile;
    }
}