<?php
/**
 * Author: alexk984
 * Date: 18.03.13
 */

class ForumParser extends LiBaseParser
{
    private $url = 'http://www.mamochka.org/forum/memberlist.php?mode=viewprofile&u=';

    public function start($start_pos)
    {
        Yii::import('site.seo.modules.mailru.models.*');
        $this->login();

        for ($i = $start_pos*1000; $i < ($start_pos+1)*1000; $i++) {
            $url = $this->url . $i;
            echo $url."\n";

            $html = $this->loadPage($url, 'Мамочка.org');
            $this->parseDocument($html, $url);
        }
    }

    public function login()
    {
        $html = $this->loadPage('http://www.mamochka.org/forum/ucp.php?mode=login');
        $document = phpQuery::newDocument($html);

        //parse rnd
        $rnd = $document->find('input[name=sid]');
        $rnd = pq($rnd)->attr('value');

        $post = 'username=novii&password=369963&autologin=on&sid='.$rnd.'&redirect=index.php&login=%D0%92%D1%85%D0%BE%D0%B4';
        $this->loadPage('http://www.mamochka.org/forum/ucp.php?mode=login', 'Мамочка.org', $post);

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