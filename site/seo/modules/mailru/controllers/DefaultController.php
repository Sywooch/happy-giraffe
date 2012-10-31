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

    public function actionTest(){
        $names = 'се
ал
ел
юл
вал
анд
яш
кис
нас
яр
кон
нат
мар
дми
ром
пре
юр
юл
евг
эл
ша
хи
та
ла
';
        $names = explode("\n", $names);
        $names = array_unique($names);
        echo count($names);

        MailruQuery::model()->deleteAll();
        foreach ($names as $name) {
            $q = new MailruQuery();
            $text = urlencode(iconv("UTF-8", "Windows-1251", $name));
            $q->text = 'http://my.mail.ru/community/momi/friends?&sort=&search_text='.$text;
            $q->type = MailruQuery::TYPE_SEARCH_USERS;
            $q->save();
        }
    }
}