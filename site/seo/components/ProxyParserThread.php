<?php
/**
 * Author: alexk984
 * Date: 01.06.12
 */
class ProxyParserThread
{
    /**
     * @var array
     */
    protected $proxy;
    /**
     * @var string thread id - random string
     */
    protected $thread_id;
    /**
     * @var int number of success page loads for current proxy
     */
    protected $success_loads = 0;
    protected $country = 'ru';

    protected $delay_min = 2;
    protected $delay_max = 5;
    public $debug = false;
    protected $timeout = 30;
    protected $removeCookieOnChangeProxy = true;
    public $use_proxy = true;

    private $_start_time = null;
    private $_time_stamp_title = '';

    function __construct()
    {
        //time_nanosleep(rand(0, 30), rand(0, 1000000000));
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $this->thread_id = rand(1, 1000000);
        $this->removeCookieFile();
        $this->getProxy();
    }

    protected function getProxy()
    {
        $this->startTimer('find proxy');
        $this->proxy = ProxyMongo::model()->getProxy();
        $this->endTimer();
    }

    protected function query($url, $ref = null, $post = false, $attempt = 0)
    {
        $this->log('start curl');
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:18.0) Gecko/20100101 Firefox/18.0');
            if ($post) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            }

            if (!empty($ref))
                curl_setopt($ch, CURLOPT_REFERER, $url);

            if ($this->use_proxy) {
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
                curl_setopt($ch, CURLOPT_PROXY, $this->proxy['value']);
                if (Yii::app()->params['use_proxy_auth']) {
                    curl_setopt($ch, CURLOPT_PROXYUSERPWD, "nikitahg:GsB84twqiGvuVz");
                    curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
                }
            }

            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->getCookieFile());
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->getCookieFile());
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
            if ($this->startsWith($url, 'https')) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            }
            $content = curl_exec($ch);

            if ($content === false) {
                $attempt += 1;
                if ($attempt > 1) {
                    $this->changeBadProxy();
                    $attempt = 0;
                }

                if (curl_errno($ch))
                    $this->log('Error while curl: ' . curl_error($ch));

                curl_close($ch);
                return $this->query($url, $ref, $post, $attempt);
            } else {
                curl_close($ch);
                if (strpos($content, 'Нам очень жаль, но запросы, поступившие с вашего IP-адреса, похожи на автоматические.')) {
                    $this->log('ip banned');
                    $this->changeBadProxy(0);
                    return $this->query($url, $ref, $post, $attempt);
                }
                $this->log('page loaded by curl');
                return $content;
            }
        }

        return '';
    }

    protected function changeBadProxy($rank = null)
    {
        $this->log('Change bad proxy');
        if (!$rank)
            $rank = floor((($this->proxy['rank'] + $this->success_loads) / 5) * 4);

        ProxyMongo::model()->updateProxyRank($this->proxy, $rank);
        $this->getProxy();
        $this->success_loads = 0;

        if ($this->removeCookieOnChangeProxy)
            $this->removeCookieFile();

        $this->afterProxyChange();
    }

    protected function changeBannedProxy()
    {
        $this->log('Change proxy');
        ProxyMongo::model()->updateProxyRank($this->proxy, 0);
        $this->getProxy();
        $this->success_loads = 0;

        if ($this->removeCookieOnChangeProxy)
            $this->removeCookieFile();

        $this->afterProxyChange();
    }

    private function saveProxy()
    {
        ProxyMongo::model()->updateProxyRank($this->proxy, $this->proxy['rank'] + $this->success_loads);
    }

    protected function closeThread($reason = 'unknown reason')
    {
        //save proxy
        if ($this->proxy !== null)
            $this->saveProxy();
        $this->removeCookieFile();

        $this->log('Thread closed: ' . $reason);
        Yii::app()->end();
    }

    protected function removeCookieFile()
    {
        if (file_exists($this->getCookieFile()))
            unlink($this->getCookieFile());
    }

    protected function getCookieFile()
    {
        return Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR . $this->thread_id . '.txt';
    }

    protected function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    protected function afterProxyChange()
    {

    }

    public function startTimer($title)
    {
        $this->_start_time = microtime(true);
        $this->_time_stamp_title = $title;
    }

    public function endTimer()
    {
        $fh = fopen($dir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'my_log.txt', 'a');
        $long_time = round(microtime(true) - $this->_start_time, 6);
        if ($long_time > 10)
            $long_time = round($long_time);
        fwrite($fh, $this->_time_stamp_title . ': ' . $long_time . "\n");
    }

    protected function log($state, $important = false)
    {
        if ($this->debug) {
            echo $state . "\n";
        } else {
            if ($important) {
                $fh = fopen($dir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'my_log.txt', 'a');
                fwrite($fh, $state . "\n");
            }
        }
    }
}
