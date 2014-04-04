<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 04/04/14
 * Time: 12:20
 * To change this template use File | Settings | File Templates.
 */

class MailMessageFactory
{
    public static function create($userId, $type)
    {
        switch ($type) {
            case MailModule::TYPE_MESSAGES:
                return new MailMessageDialogues($userId, $type);
        }
    }
}