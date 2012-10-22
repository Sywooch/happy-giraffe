<?php
/**
 * Author: alexk984
 * Date: 17.10.12
 */
class MailRuUserParser extends ProxyParserThread
{
    public $cookie = 'VID=3vjQa30CpM12; p=wFAAAM2c0QAA; mrcu=3D044FE31A915E22652EFA01060A; b=Dz0BAAAIhAcAIUpCCSQzSgCAUb5DiHJIZpi+LAEA; odklmapi=$$14qtcq4M9IEnmSONbJcUdP=gvfq14qm/Dk/GPq+zDgrrn2; __utma=56108983.385009715.1350452484.1350452484.1350625394.2; __utmz=56108983.1350625394.2.2.utmcsr=my.mail.ru|utmccn=(referral)|utmcmd=referral|utmcct=/mail/pryadkoa/; i=AQB36IBQAQBdAAUCAQA=; Mpop=1350625448:7a425f570a4f416f19050219081d00041c0600024966535c465d0002020607160105701658514704041658565c5d1a454c:aiv45@mail.ru:; tagcloud_state=show; calendar_state=show; c=reiAUAAAAMZnAAAjAgAAfAAAescJBAAA; __utmc=56108983; hses=1; myc=; __utmb=56108983.1.10.1350625394';
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

        $this->parseBabies($content);
        $this->parseMoiMir($content);
    }

    /**
     * @param $content string
     */
    public function parseMoiMir($content)
    {
        $document = phpQuery::newDocument($content);
        $moi_mir_link = trim($document->find('#personal_lay .p_links .p_acts.i_acts a.p_mm')->attr('href'));
        if (!empty($moi_mir_link)) {
            $this->user->moi_mir_url = $moi_mir_link;
            $this->user->save();
//            $content = $this->query($moi_mir_link);
//            $document = phpQuery::newDocument($content);
//            $birthday = trim($document->find('td.mf_vti div.mb3 span.mf_nobr:eq(0)')->text());
//            $birthday = date("Y-m-d", strtotime(HDate::translate_date($birthday)));
//            echo $birthday."<br>";
//
//            $last_visit = trim($document->find('td.mf_vti div.mb3.nobr')->text());
//            $last_visit = str_replace('в', '', $last_visit);
//            $last_visit = str_replace('Последний визит:', '', $last_visit);
//            echo HDate::translate_date($last_visit)."<br>";
//            $last_visit = date("Y-m-d", strtotime(HDate::translate_date($last_visit)));
//            echo $last_visit."<br>";
//
//            $document->unloadDocument();
        }
    }

    /**
     * @param $content string
     */
    public function parseBabies($content)
    {
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

        $data = $document->find('#igrow_aboutme .post_text .g_body table tr:eq(0)');
        $gender = trim(pq($data)->find('td:eq(0) span')->text());
        //echo $gender."<br>";
        if (!empty($gender))
            $baby->gender = ($gender == 'Я родился') ? 1 : 0;

        $birthday = trim(pq($data)->find('td:eq(1)')->text());
        if (!empty($birthday)) {
            $birthday = substr($birthday, 0, 10);
            $baby->birthday = date("Y-m-d", strtotime($birthday));
        }
        //echo $birthday."<br>";

        $document->unloadDocument();

        $baby->parent_id = $this->user->id;
        $exist = MailruBaby::model()->findByAttributes(array(
            'name' => $baby->name,
            'parent_id' => $baby->parent_id,
            'birthday' => $baby->birthday
        ));
        if ($exist == null)
            $baby->save();
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

            if ($this->use_proxy) {
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
                curl_setopt($ch, CURLOPT_PROXY, $this->proxy->value);
                if (getenv('SERVER_ADDR') != '5.9.7.81') {
                    curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia12345");
                    curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
                }
            }

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
                $attempt++;

                if (strpos($content, 'http://deti.mail.ru/') === false
                    && strpos($content, 'http://my.mail.ru/') === false
                )
                    return $this->query($url, $ref, $post, $attempt);
                return $content;
            }
        }

        return '';
    }
}

