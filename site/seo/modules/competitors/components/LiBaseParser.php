<?php
/**
 * Author: alexk984
 * Date: 14.12.12
 */
class LiBaseParser
{
    public $thread_id;
    public $proxy = null;
    public $last_url;
    public $use_proxy;
    public $debug_mode = false;

    public function __construct($use_proxy = true, $debug_mode = false)
    {
        $this->use_proxy = $use_proxy;
        $this->debug_mode = $debug_mode;
        $this->thread_id = substr(md5(microtime()), 0, 10);
    }

    public function loadPage($page_url, $require_text = 'LiveInternet', $post = '')
    {
        sleep(1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
        curl_setopt($ch, CURLOPT_URL, $page_url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);

        if (!empty($this->last_url))
            curl_setopt($ch, CURLOPT_REFERER, $this->last_url);

        if (!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HEADER, array('Content-Type: application/x-www-form-urlencoded', 'Content-Length: ' . strlen($post)));
        }

        if ($this->use_proxy) {
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $this->getProxy());

            if (getenv('SERVER_ADDR') != '5.9.7.81') {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia12345");
                curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
            }
        }

        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->getCookieFile());
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->getCookieFile());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result === false || strpos($result, $require_text) === false) {
            $this->log("curl fail, attempt");
            $this->changeRuProxy();

            return $this->loadPage($page_url, $post);
        }

        $this->last_url = $page_url;
        return $result;
    }

    public function getCookieFile()
    {
        $filename = Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR . 'li_' . $this->thread_id . '.txt';
        return $filename;
    }

    public function getProxy()
    {
        if (empty($this->proxy)) {
            $this->changeRuProxy();
            $this->log("new proxy: " . $this->proxy);
        }

        return $this->proxy;
    }

    public function changeRuProxy()
    {
        preg_match('/([\d:\.]+);RU/', $this->getRuProxyList(), $match);
        $this->proxy = $match[1];
    }

    public function getRuProxyList()
    {
        $cache_id = 'ru_proxy_list';
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            $value = file_get_contents('http://awmproxy.com/allproxy.php?country=1');
            Yii::app()->cache->set($cache_id, $value, 100);
        }

        return $value;
    }

    /**
     * @param int $id model id
     * @return Site
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Site::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function log($str)
    {
        if ($this->debug_mode)
            echo $str."\n";
    }
}
