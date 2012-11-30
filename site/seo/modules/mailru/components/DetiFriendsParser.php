<?php
/**
 * Author: alexk984
 * Date: 31.10.12
 */
class DetiFriendsParser extends ProxyParserThread
{
    /**
     * @var MailruUser
     */
    private $user;
    public $page = '';

    public function start()
    {
        while (true) {
            $this->getPage();

            while (!empty($this->page) && $this->page < 101)
                $this->parsePage();

            $this->closeQuery();
        }
    }

    public function getPage()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('parse_friends', 0);
        $criteria->addCondition('deti_url IS NOT NULL');

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->user = MailruUser::model()->find($criteria);
            if ($this->user === null)
                Yii::app()->end();

            $this->user->parse_friends = 1;
            $this->user->save();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }

        $this->page = 1;
    }

    public function parsePage()
    {
        $query = 'http://deti.mail.ru/inc/list_friends/?p=' . $this->page . '&email=' . $this->user->email . '&filtr=2&type=friends';
        $content = $this->query($query);
        $content = iconv('WINDOWS-1251', 'UTF-8',  $content);
        if (strpos($content, '/inc/list_friends') === false) {
            $this->changeBadProxy();
            $this->parsePage();
        } else {
            $document = phpQuery::newDocument($content);
            $count = 0;
            foreach ($document->find('div.b_friend_ava div.link_friend_nick > a') as $link) {
                $name = trim(pq($link)->text());
                $url = pq($link)->attr('href');
                $this->addUser($url, $name);
                $count++;
            }

            $document->unloadDocument();

            if ($count == 20)
                $this->page++;
            else
                $this->page = null;
        }
    }

    public function addUser($deti_url, $name)
    {
        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $user = new MailruUser();
            $user->deti_url = $deti_url;
            $user->email = $user->calculateEmail2();
            if (!empty($user->email) && MailruUser::model()->findByAttributes(array('email' => $user->email)) == null) {
                $user->name = $name;
                $user->save();
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }
    }

    private function closeQuery()
    {
        $this->user->parse_friends = 2;
        $this->user->save();
    }

    protected function query($url, $ref = null, $post = false, $attempt = 0)
    {
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:16.0) Gecko/20100101 Firefox/16.0');

            if (!empty($ref))
                curl_setopt($ch, CURLOPT_REFERER, $url);

            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->getCookieFile());
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->getCookieFile());
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
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

