<?php
/**
 * Author: alexk984
 * Date: 14.02.13
 */
class GoogleMapsApiParser
{
    protected $debug_mode = true;
    protected $proxy;
    protected $use_proxy = true;

    /**
     * @param $url string
     * @param int $attempt
     * @return array
     */
    protected function loadPage($url, $attempt = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXY, $this->getProxy());

        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexhg:Nokia1111");
        curl_setopt($ch, CURLOPT_PROXYAUTH, 1);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);
        if (isset($result['status']) && $result['status'] == 'OK') {
            return $result;
        } else {
            if (isset($result['status'])){
                echo $result['status']."\n";
                if (in_array($result['status'], array('ZERO_RESULTS', 'NOT_FOUND')))
                    return $result;
            }
            $this->changeProxy();

            if (isset($result['status']))
                $this->log($result['status']);

            if ($attempt > 10)
                return $result;

            $attempt++;
            return $this->loadPage($url, $attempt);
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
