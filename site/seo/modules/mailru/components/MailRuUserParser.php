<?php
/**
 * Author: alexk984
 * Date: 17.10.12
 */
class MailRuUserParser extends ProxyParserThread
{
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

        $transaction = Yii::app()->db_seo->beginTransaction();
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

            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->getCookieFile());
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->getCookieFile());
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

                if (strpos($content, 'http://my.mail.ru/') === false)
                    return $this->query($url, $ref, $post, $attempt);
                return $content;
            }
        }

        return '';
    }

    public function getCookieFile()
    {
        $filename = Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR . 'mailru.txt';

        return $filename;
    }
}

