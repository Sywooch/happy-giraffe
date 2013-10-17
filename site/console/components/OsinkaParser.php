<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/17/13
 * Time: 2:49 PM
 * To change this template use File | Settings | File Templates.
 */

class OsinkaParser
{
    public function start()
    {
        SiteEmail::model()->deleteAll();

        $i = 0;
        $failsInRow = 0;
        while (true) {
            $i++;
            $url = 'http://club.osinka.ru/profile.php?mode=viewprofile&u=' . $i;
            $response = $this->query($url);
            $success = $this->processQuery($response, $url);
            $failsInRow = $success ? 0 : ++$failsInRow;
            if ($failsInRow == 100)
                Yii::app()->end();
            echo $i . "\n";
        }
    }

    public function processQuery($response, $source)
    {
        echo $response;
        die;

        $html = str_get_html(iconv('Windows-1251', 'UTF-8', $response));

        if ($html->find('.messagebox', 0) !== null && $html->find('.messagebox', 0)->innertext == 'Извините, такого пользователя не существует')
            return false;

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

        $contactsTable = end($table->find('table'));

        $emailVal = $contactsTable->find('td', 1)->find('b', 0);
        $email = $emailVal->innertext == '&nbsp;' ? null : str_replace('mailto:', '', $emailVal->find('a', 0)->getAttribute('href'));

        $icqVal = $contactsTable->find('td', 5)->find('b', 0);
        $icq = $icqVal->innertext = '&nbsp;' ? null : $icqVal->innerText;

        $model = new SiteEmail();
        $attributes = compact('name', 'registered', 'messagesCount', 'from', 'occupation', 'site', 'interests', 'birthday', 'zodiac', 'avatar', 'email', 'icq', 'source');
        $model->initSoftAttributes(array_keys($attributes));
        foreach ($attributes as $a => $v)
            $model->$a = $v;
        $model->save();
        return true;
    }

    public function query($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}