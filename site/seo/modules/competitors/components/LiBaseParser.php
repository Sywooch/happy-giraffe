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
    public $rus_proxy = true;

    public function __construct($use_proxy = true, $debug_mode = false)
    {
        time_nanosleep(rand(0, 5), rand(0, 1000000000));
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

            if (Yii::app()->params['use_proxy_auth']) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia12345");
                curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
            }
        }

        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->getCookieFile());
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->getCookieFile());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);

        if ($result === false || strpos($result, $require_text) === false) {
            if ($result === false)
                $this->log("curl fail " . curl_error($ch));
            else
                $this->log("text << $require_text >> not found on page $page_url");

            curl_close($ch);
            $this->changeProxy();

            return $this->loadPage($page_url, $require_text, $post);
        }

        curl_close($ch);
        $this->last_url = $page_url;
        return $result;
    }

    public function getCookieFile()
    {
        $filename = Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR . 'li_' . $this->thread_id . '.txt';
        return $filename;
    }

    protected function removeCookieFile()
    {
        if (file_exists($this->getCookieFile()))
            unlink($this->getCookieFile());
    }

    public function getProxy()
    {
        if (empty($this->proxy))
            $this->changeProxy();

        return $this->proxy;
    }

    public function changeProxy()
    {
        if ($this->use_proxy) {
            if ($this->rus_proxy)
                $list = $this->getRuProxyList();
            else
                $list = $this->getProxyList();
            $this->proxy = $list[rand(0, count($list) - 1)];
            $this->log('proxy: ' . $this->proxy);
        }
    }

    public function getProxyList()
    {
        $cache_id = 'proxy_list';
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            $file = file_get_contents('http://awmproxy.com/allproxy.php?country=1');

            //select only rus proxy
            preg_match_all('/([\d:\.]+);/', $file, $matches);
            $value = array();
            for ($i = 0; $i < count($matches[0]); $i++) {
                $value[] = $matches[1][$i];
            }

            Yii::app()->cache->set($cache_id, $value, 300);
        }

        return $value;
    }

    public function getRuProxyList()
    {
        $cache_id = 'ru_proxy_list';
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            $file = file_get_contents('http://awmproxy.com/allproxy.php?country=1');

            //select only rus proxy
            preg_match_all('/([\d:\.]+);UA/', $file, $matches);
            $value = array();
            for ($i = 0; $i < count($matches[0]); $i++) {
                $value[] = $matches[1][$i];
            }

            Yii::app()->cache->set($cache_id, $value, 300);
        }

        return $value;
    }

    /**
     * @param int $id model id
     * @return Site
     * @throws CHttpException
     */
    protected function loadModel($id)
    {
        $model = Site::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function log($str)
    {
        if ($this->debug_mode)
            echo $str . "\n";
    }
}
