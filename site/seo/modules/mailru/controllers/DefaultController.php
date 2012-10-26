<?php

class DefaultController extends SController
{
    public function actionIndex()
    {
//        $parser = new MailRuUserParser;
//        $parser->start();
    }

    public function actionUsers()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.seo.models.*');

        Yii::app()->mc->updateMailruUsers();
    }

    public function actionHostStat()
    {
        $mail_hosts = array();
        $emails = Yii::app()->db->createCommand()
            ->select('email')
            ->from('users')
            ->queryColumn();
        foreach ($emails as $email) {
            preg_match('/@([\\w\\.\\-+=*_]*)/', $email, $regs);
            if (isset($regs[1])) {
                $regs[1] = strtolower($regs[1]);
                if (isset($mail_hosts[$regs[1]]))
                    $mail_hosts[$regs[1]]++;
                else
                    $mail_hosts[$regs[1]] = 1;
            }
        }
        arsort($mail_hosts);
        foreach ($mail_hosts as $mail_host => $count)
            echo $mail_host . " - $count<br>";
    }
}