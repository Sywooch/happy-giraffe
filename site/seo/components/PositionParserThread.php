<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */
class PositionParserThread
{
    const SE_YANDEX = 2;
    const SE_GOOGLE = 3;
    /**
     * @var Proxy
     */
    public $proxy;
    /**
     * @var Query
     */
    public $query;
    /**
     * @var int search engine id
     */
    public $se;
    public $country = 'ru';
    public $pages = 5;
    /**
     * @var string thread id - random string
     */
    public $thread_id;

    /**
     * @var int number of success page loads for current proxy
     */
    public $success_loads = 0;

    function __construct($se)
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $this->se = $se;
        $this->thread_id = substr(sha1(microtime()), 0, 6);
    }

    public function start()
    {
        $this->getProxy();
        $i = 0;
        while ($i < 1000) {
            $this->getPage();
            $this->parsePage();
            $this->closeQuery();
            $i++;
        }
    }

    public function perPage()
    {
        if ($this->se == self::SE_GOOGLE)
            return 10;
        if ($this->se == self::SE_YANDEX)
            return 20;
    }

    private function getProxy()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);
        $criteria->order = 'rank DESC';

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->proxy = Proxy::model()->find($criteria);
            if ($this->proxy === null){
                Yii::app()->end();
                //throw new CHttpException(404, 'Неудача при получении прокси.');
            }

            $this->proxy->active = 1;
            $this->proxy->save();
            $transaction->commit();
        }
        catch (Exception $e) {
            $transaction->rollback();
            Yii::app()->end();
            //throw new CHttpException(404, 'Неудача при получении прокси.');
        }

        echo $this->proxy->value . '<br>';
    }

    public function getPage()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('parsing', 0);
        $criteria->order = 'rand()';
        $criteria->with = array('pages', 'searchEngines');
        if ($this->se === self::SE_GOOGLE)
            $criteria->condition = 'google_parsed = 0 AND searchEngines.se_id = 3';
        else
            $criteria->condition = 'yandex_parsed = 0 AND searchEngines.se_id = 2';

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->query = Query::model()->find($criteria);
            if ($this->query === null) {
                $this->saveProxy();
                Yii::app()->end();
                //throw new CHttpException(404, 'Закончились кейворды.');
            }

            $this->query->parsing = 1;
            $this->query->save();
            $transaction->commit();
        }
        catch (Exception $e) {
            $transaction->rollback();
            $this->proxy->active = 0;
            $this->proxy->save();
            Yii::app()->end();
//            throw new CHttpException(404, 'Неудача при выбора кейворда для парсинга.');
        }

        echo $this->query->phrase . '<br>';
    }

    public function parsePage()
    {
        $found = false;

        for ($i = 0; $i < $this->pages; $i++) {
            $links = array();
            while (empty($links)) {
                if ($this->se == self::SE_GOOGLE)
                    $links = $this->loadGooglePage($i);
                if ($this->se == self::SE_YANDEX)
                    $links = $this->loadYandexPage($i);

                if (empty($links))
                    $this->changeBadProxy();
            }
            $this->success_loads++;
            //var_dump($links);

            $found = false;
            foreach ($links as $key => $link) {
                if ($this->startsWith($link, 'http://www.happy-giraffe.ru/')) {
                    $this->savePosition($link, $this->perPage() * $i + $key + 1);
                    $found = true;
                }
            }

            //echo ($i + 1) . " page is finished <br>";
            flush();
            if ($found)
                break;
            sleep(rand(3, 5));
        }
    }

    private function loadYandexPage($i)
    {
        $page = $i;
        $q = '';
        if ($page > 0)
            $q = '&p=' . $page;
        $content = $this->query('http://yandex.ru/yandsearch?text=' . urlencode($this->query->phrase) . '&zone=all&numdoc=' . $this->perPage() . '&lr=38&lang=ru' . $q);

        $document = phpQuery::newDocument($content);
        $links = array();
        foreach ($document->find('.b-body-items  h2 a.b-serp-item__title-link') as $link) {
            $links [] = pq($link)->attr('href');
        }

        return $links;
    }

    private function loadGooglePage($i)
    {
        $start = $i * $this->perPage();
        $content = $this->query('https://www.google.ru/search?q=' . urlencode($this->query->phrase) . '&btnG=%D0%9F%D0%BE%D0%B8%D1%81%D0%BA&hl=ru&newwindow=1&prmd=imvns&lr=lang_' . $this->country . '&gbv=2&country=' . $this->country . '&start=' . $start);

        $document = phpQuery::newDocument($content);
        $links = array();
        foreach ($document->find('#ires li.g h3.r a.l') as $link) {
            $links [] = pq($link)->attr('href');
        }

        return $links;
    }

    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public function query($url, $post = false, $attempt = 0)
    {
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
            if ($post) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            }
            if ($this->se == self::SE_YANDEX)
                curl_setopt($ch, CURLOPT_REFERER, 'http://yandex.ru/');
            if ($this->se == self::SE_GOOGLE)
                curl_setopt($ch, CURLOPT_REFERER, 'https://google.ru/');

            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia1111");
            curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy->value);
            curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/cookies/cookies-' . $this->thread_id . '.txt');
            curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/cookies/cookies-' . $this->thread_id . '.txt');
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
                    echo 'Ошибка curl: ' . curl_error($ch) . '<br>';
                }
                if (curl_errno($ch) == 5) {
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
                //echo "Get $url <br/>\r\n";
                flush();
                return $content;
            }
        }
    }

    public function changeBadProxy()
    {
        $this->proxy->rank = floor(($this->proxy->rank + $this->success_loads) / 2);
        $this->proxy->active = 0;
        $this->proxy->save();
        $this->getProxy();
        $this->success_loads = 0;
    }

    public function saveProxy()
    {
        $this->proxy->rank = $this->proxy->rank + $this->success_loads;
        $this->proxy->active = 0;
        $this->proxy->save();
    }

    public function savePosition($url, $pos)
    {
        $page = QueryPage::model()->findByAttributes(array(
            'query_id' => $this->query->id,
            'page_url' => $url,
        ));
        if ($page === null) {
            $page = new QueryPage();
            $page->query_id = $this->query->id;
            $page->page_url = $url;
        }

        if ($this->se == self::SE_GOOGLE)
            $page->google_position = $pos;
        if ($this->se == self::SE_YANDEX)
            $page->yandex_position = $pos;

        $page->save();
    }

    public function closeQuery()
    {
        if ($this->se == self::SE_GOOGLE)
            $this->query->google_parsed = 1;
        if ($this->se == self::SE_YANDEX)
            $this->query->yandex_parsed = 1;

        $this->query->parsing = 0;
        $this->query->save();
    }
}
