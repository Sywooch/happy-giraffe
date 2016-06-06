<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MailSenderTest
 *
 * @author crocodile
 */
class MailSenderTest extends MailSender
{

    private $testUserId = null;

    public function setTestUserId($userId)
    {
        $this->testUserId = $userId;
    }

    public function process(User $user)
    {
        $message = new MailMessageGeneric($user, array('templateFile' => 'test'));
        $message->type = 'test';
        Yii::app()->postman->send($message);
    }

    public function getUsersCriteria()
    {
        if ($this->testUserId == null)
        {
            throw new Exception("not set user_id for test mailing");
        }
        $criteria = new CDbCriteria();
        $criteria->compare('t.id', $this->testUserId);
        return $criteria;
    }

}
