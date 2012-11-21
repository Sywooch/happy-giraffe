<?php

class DefaultController extends SController
{
    public function actionIndex()
    {
        $parser = new DetiUserSearchParser;
        $parser->start();
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

    public function actionTest()
    {
        $str = array('а', 'б', 'в', 'г', 'д', 'е', 'ж', 'з', 'и', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'т', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'э', 'ю', 'я');
        for ($i = 0; $i < count($str); $i++)
            for ($i2 = 0; $i2 < count($str); $i2++)
                for ($i3 = 0; $i3 < count($str); $i3++) {
                    $text = $str[$i] . $str[$i2] . $str[$i3];
                    $q = new MailruQuery();
                    $text = urlencode(iconv("UTF-8", "Windows-1251", $text));
                    $q->text = 'http://deti.mail.ru/our_community/?community_filter=name&community_find=1&community_nick=' . $text;
                    $q->type = MailruQuery::TYPE_SEARCH_USERS;
                    $q->save();
                }
    }
}