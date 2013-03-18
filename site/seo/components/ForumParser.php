<?php
/**
 * Author: alexk984
 * Date: 18.03.13
 */

class ForumParser extends LiBaseParser
{
    private $url = 'http://www.mamochka.org/forum/memberlist.php?mode=viewprofile&u=';

    public function start()
    {
        Yii::import('site.seo.modules.mailru.models.*');
        for ($i = 28000; $i < 28010; $i++) {
            $url = $this->url . $i;

            $html = $this->loadPage($url, 'Мамочка.org');
            $this->parseDocument($html, $url);
        }
    }

    public function getCookieFile()
    {
        $filename = Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR . 'mail2.txt';
        return $filename;
    }

    public function parseDocument($html, $url)
    {
        //<h2>Профиль пользователя nakWasiashWef</h2>
        $r = '`\<h2>Профиль пользователя ([^>]+)<\/h2\>`ism';
        preg_match_all($r, $html, $matches, PREG_SET_ORDER);
        if (isset($matches[0][1]))
            $name = $matches[0][1]."\n";

        $r = '`\<a([^>]+)href\=\"mailto\:([^">]+)\"([^>]*)\>`ism';
        preg_match_all($r, $html, $matches, PREG_SET_ORDER);

        if (isset($matches[0][2]))
            $email = $matches[0][2]."\n";

        if (isset($name) && isset($email))
            ParsedEmails::add($email, $name, 'www.mamochka.org', $url);
    }
}