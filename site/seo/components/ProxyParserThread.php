<?php
/**
 * Author: alexk984
 * Date: 01.06.12
 */
class ProxyParserThread
{
    /**
     * @var Proxy
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

    protected $delay_min = 10;
    protected $delay_max = 10;
    public $debug = false;
    protected $timeout = 15;
    protected $removeCookieOnChangeProxy = true;
    public $use_proxy = true;
    private $_start_time = null;
    private $_time_stamp_title = '';

    function __construct()
    {
        sleep(rand(0, 10));
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $this->thread_id = substr(sha1(microtime()), 0, 10);
        $this->getProxy();
    }

    private function getProxy()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);
        $criteria->order = 'rank DESC';

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->startTimer('find proxy');
            $this->proxy = Proxy::model()->find($criteria);
            $this->endTimer();
            if ($this->proxy === null) {
                $this->closeThread('No proxy');
            }

            $this->proxy->active = 1;
            $this->startTimer('save proxy');
            $this->proxy->save();
            $this->endTimer();

            $this->startTimer('commit proxy');
            $transaction->commit();
            $this->endTimer();
        } catch (Exception $e) {
            $transaction->rollback();
            $this->closeThread('Fail with getting proxy');
        }

        $this->log('proxy: ' . $this->proxy->value);
    }

    protected function query($url, $ref = null, $post = false, $attempt = 0)
    {
        sleep(rand($this->delay_min, $this->delay_max));
        $this->log('start curl');
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.1; WOW64; U; ru) Presto/2.10.289 Version/12.00');
            if ($post) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            }

            if (!empty($ref))
                curl_setopt($ch, CURLOPT_REFERER, $url);

            /*if ($this->use_proxy) {
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
                curl_setopt($ch, CURLOPT_PROXY, $this->proxy->value);
                if (getenv('SERVER_ADDR') != '5.9.7.81') {
                    curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia12345");
                    curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
                }
            }*/

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
                if (curl_errno($ch)) {
                    $this->log('Error while curl: ' . curl_error($ch));
                    curl_close($ch);

                    $attempt += 1;
                    if ($attempt > 1) {
                        $this->changeBadProxy();
                        $attempt = 0;
                    }

                    return $this->query($url, $ref, $post, $attempt);
                }
                curl_close($ch);

                $this->changeBadProxy();
                return $this->query($url, $ref, $post, $attempt);
            } else {
                curl_close($ch);
                if (strpos($content, 'Нам очень жаль, но запросы, поступившие с вашего IP-адреса, похожи на автоматические.')) {
                    $this->log('ip banned');
                    //file_put_contents(Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR . 'banned.txt', $this->proxy->value."\n", FILE_APPEND);
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
        $this->log('Change proxy');

        if ($rank !== null)
            $this->proxy->rank = $rank;
        else
            $this->proxy->rank = floor((($this->proxy->rank + $this->success_loads) / 5) * 4);

        $this->proxy->active = 0;
        $this->proxy->save();
        $this->getProxy();
        $this->success_loads = 0;

        if ($this->removeCookieOnChangeProxy)
            $this->removeCookieFile();

        $this->afterProxyChange();
    }

    protected function changeBannedProxy()
    {
        $this->log('Change proxy');

        $this->proxy->delete();
        $this->getProxy();
        $this->success_loads = 0;

        if ($this->removeCookieOnChangeProxy)
            $this->removeCookieFile();

        $this->afterProxyChange();
    }

    private function saveProxy()
    {
        $this->proxy->rank = $this->proxy->rank + $this->success_loads;
        $this->proxy->active = 0;
        $this->proxy->save();
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
        $long_time = 1000*(microtime(true) - $this->_start_time);
        fwrite($fh, $this->_time_stamp_title.': '. $long_time . "\n");
    }

    protected function log($state)
    {
        if ($this->debug) {
            echo $state . "\n";
//            $fh = fopen($dir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'my_log.txt', 'a');
//            $t = microtime(true);
//            $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
//            $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));
//
//            fwrite($fh, $d->format("Y-m-d H:i:s.u") . ':  ' . $state . "\n");
        }
    }
}
