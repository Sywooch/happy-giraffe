<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/17/13
 * Time: 10:52 AM
 * To change this template use File | Settings | File Templates.
 */

Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
Yii::import('site.common.models.mongo.SiteEmail');
require_once(Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php');

class EmailParsingCommand extends CConsoleCommand
{
    public function actionOsinka()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'http://club.osinka.ru/profile.php?mode=viewprofile&u=56159');
        $response = curl_exec($ch);
        $html = str_get_html(iconv('Windows-1251', 'UTF-8', $response));

        $table = $html->find('table.forumline', 0);
        $name = str_replace('Профиль пользователя ', '', $table->find('th', 0)->innertext);
        $profileTable = $table->find('table', 0);
        $registered = $profileTable->find('td', 1)->find('b', 0)->innertext;
        $messagesCount = $profileTable->find('td', 3)->find('b', 0)->innertext;

        $fromVal = $profileTable->find('td', 7)->find('b', 0)->find('a', 0);
        $from = $fromVal->innertext == '&nbsp;' ? null : $fromVal->innertext;

        $occupationVal = $profileTable->find('td', 9)->find('b', 0);
        $occupation = $occupationVal->innertext == '&nbsp;' ? null : $occupationVal->innertext;

        $siteVal = $profileTable->find('td', 11)->find('b', 0);
        $site = $siteVal->innertext == '&nbsp;' ? null : $siteVal->find('a', 0)->innertext;

        $interests = $profileTable->find('td', 13)->innertext == '&nbsp;' ? null : $profileTable->find('td', 13)->innertext;

        $birthdayVal = $profileTable->find('td', 15)->find('b', 0)->find('span', 0);
        $birthday = $birthdayVal->innertext == 'Не указан' ? null : $birthdayVal->innertext;

        $zodiacVal = $profileTable->find('td', 17)->find('b', 0);
        $zodiac = $zodiacVal->innertext == '&nbsp;' ? null : $zodiacVal->find('img', 0)->getAttribute('alt');

        $avatar = $html->find('img.bdr', 0)->getAttribute('src');

        $contactsTable = $table->find('table', 1);

        $emailVal = $contactsTable->find('td', 1)->find('b', 0);
        $email = $emailVal->innertext == '&nbsp;' ? null : str_replace('mailto:', '', $emailVal->find('a', 0)->getAttribute('href'));

        $icqVal = $contactsTable->find('td', 5)->find('b', 0);
        $icq = $icqVal->innertext = '&nbsp;' ? null : $icqVal->innerText;

        $attributes = compact('name', 'registered', 'messagesCount', 'from', 'occupation', 'site', 'interests', 'birthday', 'zodiac', 'avatar', 'email', $icq);
        foreach ($attributes as $k => $v)
            echo $k . ': ' . ($v === null ? 'null' : $v) . "\n";
    }
}