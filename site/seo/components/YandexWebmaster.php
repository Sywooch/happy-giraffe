<?php
/**
 * Author: alexk984
 * Date: 30.05.12
 */
class YandexWebmaster extends CComponent
{

    public function login()
    {

        $hostname = 'oauth.yandex.ru';
        $ch = curl_init('https://' . $hostname . '/token');
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=password&username=alex-kireev.volg&password=happyalex&client_id=d27687353e75454b9e31062755093f8d&client_secret=d1877be966034ce082d1542fe9b1eca3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_exec($ch);
        $result = curl_multi_getcontent($ch);
        echo $result;
        curl_close($ch);
    }
}