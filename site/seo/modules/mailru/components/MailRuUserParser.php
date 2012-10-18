<?php
/**
 * Author: alexk984
 * Date: 17.10.12
 */
class MailRuUserParser extends ProxyParserThread
{
    public $cookie = 'VID=3vjQa30CpM11; p=wFAAAM2c0QAA; mrcu=3D044FE31A915E22652EFA01060A; b=DT0cAFDeoAEAPIpgkK+TgjAiGMThqoCH/AV2LjDAa3gB4f8TzEdZEO3FAjG9F6QRwaDI7AR9LjAodIFBUOQL9gRggJPoAuT/F9g2wYAn8gU/kS8A6WxBrkoLUGVeqOUnwlqOMQIAgHCqVZhxqoyXcWbQF3G2VZgB; odklmapi=$$14qtcq4M9IEnmSONbJcUdP=gvfq14qm/Dk/GPq+zDgrrn2; __utma=56108983.385009715.1350452484.1350452484.1350452484.1; __utmz=56108983.1350452484.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); i=AQAbRX5QAQBdAAUCAQA=; Mpop=1350475538:7a7364524061545019050219081d00041c0600024966535c465d0002020607160105701658514704041658565c5d1a454c:aiv45@mail.ru:; __utmc=56108983; myc=; __utma=213042059.1565892412.1350476006.1350476006.1350476006.1; __utmb=213042059.1.10.1350476006; __utmc=213042059; __utmz=213042059.1350476006.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); _ym_visorc=b; mrc=app_id%3D522858%26is_app_user%3D0%26sig%3D4cfaebf07f4479b7494b281a7081b1fd; c=6KB+UAAAAMZnAAASAQAAfgCA';
    /**
     * @var MailruUser
     */
    public $user;

    public function start()
    {
        while (true) {
            $this->getPage();
            $this->parsePage();
            $this->closeQuery();
        }
    }

    public function getPage()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $this->user = MailruUser::model()->find($criteria);
            if ($this->user === null)
                Yii::app()->end();

            $this->user->active = 1;
            $this->user->save();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }
    }

    public function parsePage()
    {
        $content = $this->query($this->user->deti_url . '?p_tab=my_family');
        $document = phpQuery::newDocument($content);
        foreach ($document->find('#pers_my_kids_all .b_rel') as $link) {
            $ava = pq($link)->find('.rel_ava a');
            $href = 'http://deti.mail.ru' . pq($ava)->attr('href');
            $this->parseBaby($href);
        }
        $document->unloadDocument();
    }

    public function parseBaby($url)
    {
        $baby = new MailruBaby();
        $content = $this->query($url);
        $document = phpQuery::newDocument($content);
        $name = $document->find('#igrow_aboutme .strokeName');
        $name = trim(pq($name)->text());
        //echo $name."<br>";
        $baby->name = $name;

        $data = $document->find('#igrow_aboutme .post_text tr:eq(0)');
        $gender = trim(pq($data)->find('span')->text());
        //echo $gender."<br>";
        if (!empty($gender))
            $baby->gender = ($gender == 'Я родился')?1:0;

        $birthday = trim(pq($data)->find('td:eq(1)')->text());
        if (!empty($birthday))
            $baby->birthday = date("Y-m-d", strtotime($birthday));
        //echo $birthday."<br>";

        $document->unloadDocument();

        $baby->parent_id = $this->user->id;
        $baby->save();
    }

    public function addUser($url, $name)
    {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $user = new MailruUser();
            $user->deti_url = $url;
            $user->email = $user->calculateEmail();
            if (!empty($user->email) && MailruUser::model()->findByAttributes(array('email' => $user->email)) == null) {
                $user->name = trim(preg_replace("/  +/", " ", $name));
                $user->save();
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }
    }

    private function closeQuery()
    {
        $this->user->active = 2;
        $this->user->save();
    }

    protected function query($url, $ref = null, $post = false, $attempt = 0)
    {
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.1; WOW64; U; ru) Presto/2.10.289 Version/12.00');

            /*if ($this->use_proxy) {
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
                curl_setopt($ch, CURLOPT_PROXY, $this->proxy->value);
                if (getenv('SERVER_ADDR') != '5.9.7.81') {
                    curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia12345");
                    curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
                }
            }*/

            curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
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
                $attempt++;

                if (strpos($content, 'http://deti.mail.ru/') === false)
                    return $this->query($url, $ref, $post, $attempt);
                return $content;
            }
        }

        return '';
    }
}

