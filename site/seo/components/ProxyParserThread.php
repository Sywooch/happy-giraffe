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
    private $thread_id;
    /**
     * @var int number of success page loads for current proxy
     */
    protected $success_loads = 0;
    protected $country = 'ru';

    protected $delay_min = 5;
    protected $delay_max = 15;
    protected $debug = true;

    function __construct()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $this->thread_id = substr(sha1(microtime()), 0, 6);
        $this->getProxy();
    }

    private function getProxy()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);
        $criteria->order = 'rank DESC';

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->proxy = Proxy::model()->find($criteria);
            if ($this->proxy === null) {
                $this->closeThread('No proxy');
            }

            $this->proxy->active = 1;
            $this->proxy->save();
            $transaction->commit();
        }
        catch (Exception $e) {
            $transaction->rollback();
            $this->closeThread('Fail with getting proxy');
        }
    }

    protected function query($url, $post = false, $attempt = 0)
    {
        sleep(rand($this->delay_min, $this->delay_max));

        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
            if ($post) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            }

            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia1111");
            curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy->value);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->getCookieFile());
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->getCookieFile());
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            if ($this->startsWith($url, 'https')) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            }
            $content = curl_exec($ch);

            if ($content === false) {
                if (curl_errno($ch)) {
                    if ($this->debug)
                        echo 'Error while curl: ' . curl_error($ch)."\n";
                    $attempt += 1;
                    if ($attempt > 2) {
                        $this->changeBadProxy();
                    }

                    return $this->query($url, $post, $attempt);
                }

                $this->changeBadProxy();
                return $this->query($url, $post, $attempt);
            }
            else {
                return $content;
            }
        }

        return '';
    }

    protected function changeBadProxy()
    {
        if ($this->debug)
            echo 'Change proxy '."\n";

        $this->proxy->rank = floor(($this->proxy->rank + $this->success_loads) / 2);
        $this->proxy->active = 0;
        $this->proxy->save();
        $this->getProxy();
        $this->success_loads = 0;

        $this->removeCookieFile();
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
        $this->proxy->rank = $this->proxy->rank + $this->success_loads;
        $this->proxy->active = 0;
        $this->proxy->save();

        $this->removeCookieFile();

        Yii::log('Thread closed: ' . $reason);
        echo 'Thread closed: ' . $reason;

        Yii::app()->end();
    }

    private function removeCookieFile()
    {
        if (file_exists($this->getCookieFile()))
            unlink($this->getCookieFile());
    }

    protected function getCookieFile()
    {
        return getcwd() . '/cookies/cookies-' . $this->thread_id . '.txt';
    }

    protected function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
}
