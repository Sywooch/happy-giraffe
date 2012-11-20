<?php
/**
 * Author: alexk984
 * Date: 31.10.12
 */
class DetiUserSearchParser extends ProxyParserThread
{
    /**
     * @var MailruQuery
     */
    private $query;
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
        $criteria->compare('active', 0);
        $criteria->compare('type', MailruQuery::TYPE_SEARCH_USERS);

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

        if (!empty($this->query->max_page))
            $this->page = $this->query->max_page;
        else
            $this->page = 1;
    }

    public function parsePage()
    {
        $content = $this->query($this->query->text . '&page=' . $this->page);
        if (strpos($content, 'http://deti.mail.ru/') === false) {
            $this->changeBadProxy();
            $this->parsePage();
        } else {
            if (strpos($content, iconv("UTF-8", "Windows-1251", 'Попробуйте изменить параметры поиска. Спасибо')) === false) {

                $document = phpQuery::newDocument($content);
                $count = 0;
                foreach ($document->find('#lay_community div.b_com_user .com_user_info > a') as $link) {
                    $name = pq($link)->text();
                    $url = pq($link)->attr('href');
                    $this->addUser($url, $name);
                    $count++;
                }

                $document->unloadDocument();

                if ($count > 0){
                    $this->page++;
                    $this->query->max_page = $this->page;
                    $this->query->update(array('max_page'));
                }
                else
                    $this->page = null;
            } else{
                $this->page = null;
            }
        }
    }

    public function addUser($deti_url, $name)
    {
        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $user = new MailruUser();
            $user->deti_url = $deti_url;
            $user->email = $user->calculateEmail();
            if (!empty($user->email) && MailruUser::model()->findByAttributes(array('email' => $user->email)) == null) {
                $user->name = trim($name);
                $user->save();
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

