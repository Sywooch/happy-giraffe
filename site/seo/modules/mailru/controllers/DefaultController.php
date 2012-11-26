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

    public function actionCollectByGeo()
    {
        $str = '<select id="community_region" name="community_region" onchange="ourCommunity.selectedRegionEvent()"><option value="">--выберите регион--</option><option value="25">Москва</option><option value="226">Санкт-Петербург</option><option value="301">Адыгея</option><option value="264">Алтайский край</option><option value="227">Амурская обл.</option><option value="252">Архангельская обл.</option><option value="302">Астраханская обл.</option><option value="237">Башкортостан</option><option value="284">Белгородская обл.</option><option value="285">Брянская обл.</option><option value="265">Бурятия</option><option value="286">Владимирская обл.</option><option value="303">Волгоградская обл.</option><option value="253">Вологодская обл.</option><option value="287">Воронежская обл.</option><option value="304">Дагестан</option><option value="228">Еврейская АО</option><option value="3425">Забайкальский край</option><option value="288">Ивановская обл.</option><option value="305">Ингушетия</option><option value="266">Иркутская обл.</option><option value="306">Кабардино-Балкария</option><option value="254">Калининградская обл.</option><option value="307">Калмыкия</option><option value="289">Калужская обл.</option><option value="229">Камчатский край</option><option value="308">Карачаево-Черкессия</option><option value="255">Карелия</option><option value="267">Кемеровская обл.</option><option value="238">Кировская обл.</option><option value="256">Коми</option><option value="290">Костромская обл.</option><option value="309">Краснодарский край</option><option value="268">Красноярский край</option><option value="278">Курганская обл.</option><option value="291">Курская обл.</option><option value="257">Ленинградская обл.</option><option value="292">Липецкая обл.</option><option value="231">Магаданская обл.</option><option value="240">Марий-Эл</option><option value="241">Мордовия</option><option value="293">Московская обл.</option><option value="258">Мурманская обл.</option><option value="259">Ненецкий АО</option><option value="242">Нижегородская обл.</option><option value="260">Новгородская обл.</option><option value="269">Новосибирская обл.</option><option value="270">Омская обл.</option><option value="243">Оренбургская обл.</option><option value="294">Орловская обл.</option><option value="244">Пензенская обл.</option><option value="245">Пермский край.</option><option value="232">Приморский край</option><option value="261">Псковская обл.</option><option value="263">Республика Алтай</option><option value="310">Ростовская обл.</option><option value="295">Рязанская обл.</option><option value="246">Самарская обл.</option><option value="247">Саратовская обл.</option><option value="233">Саха (Якутия)</option><option value="234">Сахалинская обл.</option><option value="279">Свердловская обл.</option><option value="311">Северная Осетия - Алания</option><option value="296">Смоленская обл.</option><option value="312">Ставропольский край</option><option value="297">Тамбовская обл.</option><option value="248">Татарстан</option><option value="298">Тверская обл.</option><option value="272">Томская обл.</option><option value="299">Тульская обл.</option><option value="273">Тыва</option><option value="280">Тюменская обл.</option><option value="249">Удмуртия</option><option value="250">Ульяновская обл.</option><option value="235">Хабаровский край</option><option value="275">Хакасия</option><option value="281">Ханты-Мансийский АО - Югра</option><option value="282">Челябинская обл.</option><option value="313">Чечня</option><option value="251">Чувашия</option><option value="236">Чукотский АО</option><option value="283">Ямало-Ненецкий АО</option><option value="300">Ярославская обл.</option></select>';
        preg_match_all('/value=\"([\d]+)\"/', $str, $matches);
        foreach($matches[1] as $val){
            //echo $val.'<br>';
            $url = 'http://deti.mail.ru/our_community/?community_filter=geography&community_country_selected=24&community_region_selected=264&community_city_selected=1440&community_own_region=1779&community_country=24&community_region='.$val.'&community_city=&community_find=%CD%E0%E9%F2%E8';

            $q = new MailruQuery();
            $q->text = $url;
            $q->type = MailruQuery::TYPE_SEARCH_USERS;
            $q->chars = $val;
            $q->save();
        }

    }

    public function actionCollectByNickname()
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