<?php

class DefaultController extends SController
{
    public function actionIndex()
    {
        $parser = new DetiUserSearchParser;
        $parser->start();
    }

    public function actionUpdateContestUsers(){
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.seo.models.*');

        Yii::app()->mc->updateContestUsers();
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

    public function actionCollect()
    {
        for($i=4;$i<13;$i++){
            //echo $val.'<br>';
            $url = 'http://deti.mail.ru/our_community/?community_filter=status&community_status=3&community_age_child=m_'.$i.'&community_find=%CD%E0%E9%F2%E8#';

            $q = new MailruQuery();
            $q->text = $url;
            $q->type = MailruQuery::TYPE_SEARCH_USERS;
            $q->chars = $i;
            $q->save();
        }
    }

    public function actionGetPhrases(){
        $models = MailruQuery::model()->findAll('type = 3 AND max_page > 10');

        foreach($models as $model){
            if (!empty($model->chars))
                echo $model->chars."<br>";
        }
    }

    public function actionCollectByNickname()
    {
        $str = 'абд
абр
ага
акс
але
али
алл
алс
аля
ами
ана
анг
анд
ане
анж
ани
анн
ант
ант
аню
аня
ари
арт
арт
асе
ася
ахм
баб
баг
бак
бал
бар
бат
бат
бах
без
бек
бел
бер
бес
боб
бог
бол
бон
бор
бул
бур
бут
бут
вад
вал
вар
вас
вен
вер
вик
вин
вио
вит
вит
вла
вол
вор
вяч
гав
гал
гар
гер
гил
гла
глу
гол
гон
гор
гра
гре
гри
гро
гуз
гул
гур
гус
дав
дан
дар
даш
дем
ден
дер
джа
диа
дил
дим
дин
дми
доб
дол
дор
дро
дуб
дуд
евг
его
ека
еле
ели
ерм
ефи
жан
жен
жук
жур
заг
зам
зар
зах
зин
зол
зоя
зуб
зул
ива
игн
иго
инг
инд
ине
инн
ира
ири
иса
каз
кал
кам
кан
кап
кар
кат
кас
кат
каш
ким
кир
кис
кли
ков
кож
коз
кол
ком
кон
коп
кор
кот
кос
кот
коч
кош
кра
кри
кру
ксе
ксю
куд
куз
кук
кул
кур
куч
лав
лаз
лан
лап
лар
леб
лев
лел
лен
лео
лес
лид
лиз
лил
лин
лит
лис
лит
лоб
лог
лук
люб
люд
люс
лял
мад
мак
мал
мам
ман
мар
мат
мас
мат
мах
маш
мед
мел
мер
мил
мин
мир
мит
мит
мих
миш
мол
мор
мос
мур
мус
мух
над
наз
нар
нат
нас
нат
нау
нел
нес
ник
нин
нов
нур
овч
окс
оле
оля
орл
оси
пав
пан
пар
пер
пет
пет
под
пол
пон
поп
пот
пот
при
про
рад
раз
раи
рам
рас
рах
рег
рез
рим
рит
рит
род
роз
ром
руд
рус
ряб
там
тан
тар
тат
тат
таш
тер
тим
тит
тит
тих
тка
ток
тол
том
тор
тре
тро
тру
тур
саб
сав
сад
сал
сам
сан
сар
сау
саф
саш
све
сви
сел
сем
сер
сид
сим
син
ско
сла
сми
смо
сне
соб
сок
сол
сор
соф
ста
сте
сто
стр
ста
сте
сто
стр
сул
сур
сух
сча
там
тан
тар
тат
тат
таш
тер
тим
тит
тит
тих
тка
ток
тол
том
тор
тре
тро
тру
тур
фар
фат
фат
фед
фил
фом
фро
хал
хам
хар
цве
чер
шаб
шам
шар
шев
шир
шиш
щер
эле
эли
элл
эля
юле
юли
юля
юри
яко
яку
яна
яро';
        $arr = explode("\n", $str);
        for ($i = 0; $i < count($arr); $i++){
                    $q = new MailruQuery();
                    $text = urlencode(iconv("UTF-8", "Windows-1251", $arr[$i]));
                    $q->text = 'http://my.mail.ru/community/man/friends?&sort=&search_text=' . $text;
                    $q->type = MailruQuery::TYPE_SEARCH_USERS;
                    $q->save();
                }
    }
}