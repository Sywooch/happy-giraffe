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
        time_nanosleep(rand(0, 5), rand(0, 1000000000));
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $this->thread_id = rand(1, 8000000);
        $this->getProxy();
    }

    private function getProxy()
    {
        $this->startTimer('find proxy');

//        $transaction = Yii::app()->db_keywords->beginTransaction();
//        try {
//        Yii::app()->db_seo->createCommand("update proxies set active=:pid where active=0 order by rank desc, id desc limit 1")->execute(array(':pid' => $this->thread_id));
//        $this->proxy = Proxy::model()->find('active=' . $this->thread_id);
            $criteria = new CDbCriteria;
            $criteria->compare('active', 0);
            $criteria->order = 'rank desc';
            $criteria->offset = rand(0, 10);

            $this->proxy = Proxy::model()->find($criteria);
            if ($this->proxy === null)
                $this->closeThread('No proxy');
            $this->proxy->active = 1;
            $this->proxy->update(array('active'));

//            $transaction->commit();
//        } catch (Exception $e) {
//            $transaction->rollback();
//            echo 'fail';
//            Yii::app()->end();
//        }

        $this->endTimer();
    }

    protected function query($url, $ref = null, $post = false, $attempt = 0)
    {
        //$this->log('start curl');
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
                curl_setopt($ch, CURLOPT_PROXY, $this->proxy->value);
                if (Yii::app()->params['use_proxy_auth']) {
                    curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexhg:Nokia1111");
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
                    $this->changeBadProxy(0);
                    return $this->query($url, $ref, $post, $attempt);
                }
                //$this->log('page loaded by curl');
                return $content;
            }
        }

        return '';
    }

    protected function changeBadProxy($rank = null)
    {
        //$this->log('Change proxy');

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
        //$this->log('Change proxy');

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
        $long_time = 1000 * (microtime(true) - $this->_start_time);
        fwrite($fh, $this->_time_stamp_title . ': ' . $long_time . "\n");
    }

    protected function log($state)
    {
        if ($this->debug) {
            echo $state . "\n";
        } else {
//            $fh = fopen($dir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'my_log.txt', 'a');
//            fwrite($fh, $state . "\n");
        }
    }
}
