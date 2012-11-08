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
        $names = 'алек
алек
анатолий
анастасия
аглая
алла
алис
альберт
андрей
алия
алина
арс
артем
ася
антон
борис
вадим
валя
вале
валер
василий
вася
вера
влад
владимир
вик
виктор
виталей
вит
глеб
гал
ген
гео
давид
дани
даш
дарья
динара
денис
диа
ева
евгени
егор
елена
жан
зина
зем
зоя
захар
иван
илья
игнат
игор
инна
ирина
инга
инна
арина
клав
кира
кирил
крис
ксен
леон
лариса
лид
лера
лик
лол
люд
лев
лен
лил
лор
люб
макс
макар
мари
мир
мил
мих
мус
май
марг
матр
над
наи
ник
нин
наз
ната
ники
окс
олес
олег
оль
оля
павел
плат
поли
петр
прох
регина
ринат
роза
рома
руст
раис
роб
рокс
руф
раш
рим
родион
русл
свет
серг
сере
соф
стан
стас
слав
степ
сера
спар
снеж
тама
тать
тим
терен
тарас
тих
троф
уль
фед
фом
фил
эд
эл
эр
';
        $names = explode("\n", $names);
        $names = array_unique($names);
        echo count($names);

//        MailruQuery::model()->deleteAll();
        foreach ($names as $name) {
            $q = new MailruQuery();
            $text = urlencode(iconv("UTF-8", "Windows-1251", $name));
            $q->text = 'http://my.mail.ru/community/dizzzain/friends?&sort=&search_text='.$text;
            $q->type = MailruQuery::TYPE_SEARCH_USERS;
            $q->save();
        }
    }
}