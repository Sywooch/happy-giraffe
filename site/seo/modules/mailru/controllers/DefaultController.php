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
        $names = 'але
ало
алю
анд
ане
бо
ва
ве
во
га
ге
ги
дми
да
де
ди
ел
евг
ек
ес
жи
же
зи
за
зе
кис
кон
ке
ла
ле
ли
ма
ме
ми
нас
нат
не
ни
ол
пре
па
по
ро
ра
ре
се
са
све
та
те
ти
хи
ша
эл
юл
юр
яр
яш
ян
яя
';
        $names = explode("\n", $names);
        $names = array_unique($names);
        echo count($names);

        MailruQuery::model()->deleteAll();
        foreach ($names as $name) {
            $q = new MailruQuery();
            $text = urlencode(iconv("UTF-8", "Windows-1251", $name));
            $q->text = 'http://my.mail.ru/community/dizzzain/friends?&sort=&search_text='.$text;
            $q->type = MailruQuery::TYPE_SEARCH_USERS;
            $q->save();
        }
    }
}