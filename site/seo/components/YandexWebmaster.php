<?php
/**
 * Author: alexk984
 * Date: 30.05.12
 */
class YandexWebmaster
{
    public $cookie;
    public $user_id;
    public $token = '0a7056bc27b74d04bcb2c0227cb16896';
    /**
     * @var WebmasterData
     */
    public $wm_data;
    public $application_id;

    public function login()
    {
        $this->wm_data = new WebmasterData();
        $hostname = 'webmaster.yandex.ru';
        $ch = curl_init('https://' . $hostname . '/api/me');
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $this->token));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_exec($ch);
        $result = curl_multi_getcontent($ch);
        //echo $result;

        if (preg_match('/Set-Cookie: ([^;]+;) domain=.yandex.ru/', $result, $res)) {
            $this->cookie = $res[1];
            $this->wm_data->cookie = $this->cookie;
        }

        if (preg_match('/webmaster.yandex.ru\/api\/([\d]+)\s/', $result, $res)) {
            $this->user_id = $res[1];
            echo $this->user_id . '<br>';
            $this->wm_data->user_id = $this->user_id;
        }
        else
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена. /api/me ');


        curl_close($ch);
    }

    public function readServiceDocument()
    {
        $html = $this->loadPage('/api/' . $this->user_id);
        //echo $html;

        if (preg_match('/<collection href="https:\/\/webmaster.yandex.ru([^"]+)">/', $html, $res)) {
            $url = $res[1];
            echo $url . '<br>';
            $this->wm_data->hosts_url = $url;
            $html = $this->loadPage($url);
            echo $html;

            if (preg_match('/webmaster.yandex.ru\/api\/[\d]+\/hosts\/([\d]+)"/', $html, $res)) {
                $this->application_id = $res[1];
                echo $this->application_id . '<br>';
                $this->wm_data->host = $this->application_id;
                $this->wm_data->save();

                echo $this->loadPage("/api/$this->user_id/hosts/$this->application_id/indexed");
            }
        } else
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
    }

    public function getStats()
    {
        echo $this->loadPage("/api/$this->user_id/hosts/$this->application_id/tops", false);
    }

    public function loadPage($url, $https = true)
    {
        $hostname = 'webmaster.yandex.ru';
        if ($https)
            $ch = curl_init('https://' . $hostname . $url);
        else{
            $ch = curl_init('http://' . $hostname . $url);
        }
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $this->token));
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }
        curl_exec($ch);
        $result = curl_multi_getcontent($ch);
        curl_close($ch);

        return $result;
    }
}