<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 04/04/14
 * Time: 15:27
 * To change this template use File | Settings | File Templates.
 */

class MailSenderFactory
{
    public static function create($type)
    {
        switch ($type) {
            case MailModule::TYPE_MESSAGES:
                return new MailSenderDialogues($type);
        }
    }
}