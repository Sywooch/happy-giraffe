<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/04/14
 * Time: 14:26
 * To change this template use File | Settings | File Templates.
 */

class MailMessageDaily extends MailMessage
{
    public $type = 'general';
    public $horoscope;
    public $posts = array();

    public function getSubject()
    {
        return time();
    }
}