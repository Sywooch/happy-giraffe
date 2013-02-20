<?php
/**
 * Author: alexk984
 * Date: 14.02.13
 */
class GoogleMapsApiParser
{
    protected $debug_mode = false;
    protected $proxy;
    protected $use_proxy = true;

    public function __construct($debug_mode = false, $use_proxy = false)
    {
        $this->debug_mode = $debug_mode;
        $this->use_proxy = $use_proxy;
    }

    /**
     * @param $url string
     * @return array
     */
    protected function loadPage($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
        curl_setopt($ch, CURLOPT_URL, $url);

        if ($this->use_proxy) {
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $this->getProxy());

            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexhg:Nokia1111");
            curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
        } else
            sleep(1);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);
        if (isset($result['status']) && $result['status'] == 'OK') {
            return $result;
        } else {
            if (!$this->use_proxy)
                return $result;

            if (isset($result['status'])) {
                if (in_array($result['status'], array('ZERO_RESULTS', 'NOT_FOUND')))
                    return $result;

                if (isset($result['status']) && $result['status'] == 'OVER_QUERY_LIMIT') {
                    $this->changeProxy();
                    return $this->loadPage($url);
                }

                $this->log($result['status']);
            }

            return $result;
        }
    }

    protected function getProxy()
    {
        if (empty($this->proxy))
            $this->changeProxy();

        return $this->proxy;
    }

    protected function changeProxy()
    {
        if ($this->use_proxy) {
//            echo 'use proxy!!!!!!';
//            Yii::app()->end();
            $list = $this->getProxyList();
            $this->proxy = $list[rand(0, count($list) - 1)];
        }
    }

    protected function getProxyList()
    {
        $cache_id = 'proxy_list';
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            $file = file_get_contents('http://awmproxy.com/allproxy.php?country=1');

            preg_match_all('/([\d:\.]+);/', $file, $matches);
            $value = array();
            for ($i = 0; $i < count($matches[0]); $i++)
                $value[] = $matches[1][$i];

            Yii::app()->cache->set($cache_id, $value, 300);
        }

        return $value;
    }

    /**
     * @param $str string
     */
    protected function log($str)
    {
        if ($this->debug_mode)
            echo $str . "\n";
    }
}
