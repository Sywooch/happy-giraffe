<?php
/**
 * Author: alexk984
 * Date: 17.10.12
 */
class MailRuForumParser extends ProxyParserThread
{
    public $cookie = 'VID=3vjQa30CpM11; p=wFAAAM2c0QAA; mrcu=3D044FE31A915E22652EFA01060A; b=DT0cAFDeoAEAPIpgkK+TgjAiGMThqoCH/AV2LjDAa3gB4f8TzEdZEO3FAjG9F6QRwaDI7AR9LjAodIFBUOQL9gRggJPoAuT/F9g2wYAn8gU/kS8A6WxBrkoLUGVeqOUnwlqOMQIAgHCqVZhxqoyXcWbQF3G2VZgB; odklmapi=$$14qtcq4M9IEnmSONbJcUdP=gvfq14qm/Dk/GPq+zDgrrn2; __utma=56108983.385009715.1350452484.1350452484.1350452484.1; __utmz=56108983.1350452484.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); i=AQAbRX5QAQBdAAUCAQA=; Mpop=1350475538:7a7364524061545019050219081d00041c0600024966535c465d0002020607160105701658514704041658565c5d1a454c:aiv45@mail.ru:; __utmc=56108983; myc=; __utma=213042059.1565892412.1350476006.1350476006.1350476006.1; __utmb=213042059.1.10.1350476006; __utmc=213042059; __utmz=213042059.1350476006.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); _ym_visorc=b; mrc=app_id%3D522858%26is_app_user%3D0%26sig%3D4cfaebf07f4479b7494b281a7081b1fd; c=6KB+UAAAAMZnAAASAQAAfgCA';
    /**
     * @var MailruQuery
     */
    private $query;
    private $page = 1;

    public function start()
    {
        $this->getPage();
        while (true) {
            $count = $this->parsePage();
            if ($count == 0)
                break;
            $this->page++;
        }
        $this->closeQuery();
    }

    public function getPage()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);
        $criteria->compare('type', MailruQuery::TYPE_FORUM);

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->query = MailruQuery::model()->find($criteria);
            if ($this->query === null)
                Yii::app()->end();

            $this->query->active = 1;
            $this->query->save();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }
    }

    public function parsePage()
    {
        $content = $this->query($this->query->text.'&pg='.$this->page);
        if (strpos($content, 'http://deti.mail.ru/') === false) {
            $this->changeBadProxy();
            $count = $this->parsePage();
        } else {
            $document = phpQuery::newDocument($content);
            $count = 0;
            foreach ($document->find('table.themesList > tr > td > div.t100 > a') as $link) {
                $url = 'http://forum.deti.mail.ru'.pq($link)->attr('href');
                $this->addTheme($url);
                $count++;
            }
            $document->unloadDocument();
        }

        return $count;
    }

    public function addTheme($url)
    {
        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            if (MailruQuery::model()->findByAttributes(array('text' => $url)) == null) {
                $theme = new MailruQuery();
                $theme->text = $url;
                $theme->type = MailruQuery::TYPE_THEME;
                $theme->save();
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }
    }

    private function closeQuery()
    {
        $this->query->active = 2;
        $this->query->save();
    }

    protected function query($url, $ref = null, $post = false, $attempt = 0)
    {
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.1; WOW64; U; ru) Presto/2.10.289 Version/12.00');

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

            //curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $content = curl_exec($ch);

//            $content = iconv("Windows-1251","UTF-8",$content);

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
                return $content;
            }
        }

        return '';
    }


    public static function collectContests()
    {
        $contests = array(
            'http://forum.deti.mail.ru/topics.html?fid=51',
            'http://forum.deti.mail.ru/topics.html?fid=71',
            'http://forum.deti.mail.ru/topics.html?fid=5',
            'http://forum.deti.mail.ru/topics.html?fid=55',
            'http://forum.deti.mail.ru/topics.html?fid=6',
            'http://forum.deti.mail.ru/topics.html?fid=7',
            'http://forum.deti.mail.ru/topics.html?fid=8',
            'http://forum.deti.mail.ru/topics.html?fid=52',
            'http://forum.deti.mail.ru/topics.html?fid=53',
            'http://forum.deti.mail.ru/topics.html?fid=56',
            'http://forum.deti.mail.ru/topics.html?fid=16',
            'http://forum.deti.mail.ru/topics.html?fid=57',
            'http://forum.deti.mail.ru/topics.html?fid=104',
        );
        foreach($contests as $contest)
        for($i=1;$i<30;$i++){
            $q = new MailruQuery();
            $q->text = $contest;
            $q->save();
        }
    }
}

