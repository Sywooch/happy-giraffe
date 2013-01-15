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

            if (!in_array(getenv('SERVER_ADDR'), array('5.9.7.81', '88.198.24.104'))) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexhg:Nokia1111");
                curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
            }
        }

        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->getCookieFile());
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->getCookieFile());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result === false || strpos($result, $require_text) === false) {
            if (strpos($result, $require_text) === false){
                $this->log("text << $require_text >> not found");
            }
            else
                $this->log("curl fail ".curl_errno($ch));
            $this->proxy = null;
            $this->getProxy();

            return $this->loadPage($page_url, $require_text, $post);
        }

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
        if (empty($this->proxy)){
            if ($this->rus_proxy)
                $this->changeRuProxy();
            else
                $this->changeProxy();
        }

        return $this->proxy;
    }

    public function changeRuProxy()
    {
        if ($this->use_proxy) {
            preg_match_all('/([\d:\.]+);RU/', $this->getRuProxyList(), $matches);
            $this->proxy = $matches[1][rand(0, count($matches[0]) - 1)];
            $this->log('proxy: '.$this->proxy);
        }
    }

    public function changeProxy()
    {
        if ($this->use_proxy) {
            $criteria = new CDbCriteria;
            $criteria->order = 'RAND()';
            $proxy = Proxy::model()->find($criteria);

            $this->proxy = $proxy->value;
            $this->log('proxy: '.$this->proxy);
        }
    }

    public function getRuProxyList()
    {
        $cache_id = 'ru_proxy_list';
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            $value = file_get_contents('http://awmproxy.com/allproxy.php?country=1');
            Yii::app()->cache->set($cache_id, $value, 500);
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
            echo $str . "\n";
    }
}
