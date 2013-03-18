<?php
/**
 * Author: alexk984
 * Date: 18.03.13
 */

class ForumParser2 extends LiBaseParser
{
    private $url = 'http://forum.rostovmama.ru/index.php?action=profile;u=';
    private $text = 'www.forum.rostovmama.ru';

    public function start($start_pos)
    {
        Yii::import('site.seo.modules.mailru.models.*');
        $this->login();

        for ($i = $start_pos * 1000; $i < ($start_pos + 1) * 1000; $i++) {
            $url = $this->url . $i;
            $html = $this->loadPage($url, $this->text);
            $this->parseDocument($html, $url);
        }
    }

    public function login()
    {
        $this->loadPage('http://forum.rostovmama.ru/', $this->text);

        $post = 'user=novii&passwrd=369963&cookielength=-1&hash_passwrd=';
        $this->loadPage('http://forum.rostovmama.ru/index.php?PHPSESSID=bc714664d72f1fbbc14c96d43833e81e&action=login2', $this->text, $post);
    }

    public function parseDocument($html, $url)
    {
        $html = iconv("Windows-1251", "UTF-8", $html);

        $r = '`\<title>Просмотр профиля ([^<]+)<\/title>`ism';
        preg_match_all($r, $html, $matches, PREG_SET_ORDER);
        if (isset($matches[0][1]))
            $name = $matches[0][1] . "\n";

        $r = '`\<a([^>]+)href\=\"mailto\:([^">]+)\"([^>]*)\>`ism';
        preg_match_all($r, $html, $matches, PREG_SET_ORDER);

        if (isset($matches[0][2]))
            $email = $matches[0][2] . "\n";

        if (isset($name) && isset($email))
            ParsedEmails::add($email, $name, 'forum.rostovmama.ru', $url);
        else {
//            if (!isset($name))
//                echo 'name not_found';
//            if (!isset($email))
//                echo 'email not_found';
        }
    }
}