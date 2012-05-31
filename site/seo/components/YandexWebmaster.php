<?php
/**
 * Author: alexk984
 * Date: 30.05.12
 */
class YandexWebmaster extends CComponent
{

    public function login()
    {
        $hostname = 'webmaster.yandex.ru';
        $ch = curl_init('https://' . $hostname . '/api/me');
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization'=>'OAuth 3c1b05e08f6647699ba611c9836a1b9e'));
        curl_exec($ch);
        $result = curl_multi_getcontent($ch);
        echo $result;
        curl_close($ch);
    }
}