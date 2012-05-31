<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */
class PositionParserThread
{
    const SE_YANDEX = 1;
    const SE_GOOGLE = 2;

    /**
     * @var Proxy
     */
    public $proxy;
    /**
     * @var Queries
     */
    public $query;
    public $se;

    function __construct($se)
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $this->se = $se;
    }

    public function start()
    {
        $this->getProxy();
        //while (true) {
            $this->getPage();
            if ($this->se === self::SE_GOOGLE)
                $this->parseGoogle();
            if ($this->se === self::SE_YANDEX)
                $this->parseYandex();

        $this->query->parsing = 0;
        $this->query->save();
        //}
    }

    private function getProxy()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);
        $criteria->order = 'rand()';

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->proxy = Proxy::model()->find($criteria);
            if ($this->proxy === null)
                throw new CHttpException(404, 'Неудача при получении прокси.');

            $this->proxy->active = 1;
            $this->proxy->save();
            $transaction->commit();
        }
        catch (Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404, 'Неудача при получении прокси.');
        }

        echo $this->proxy->value.'<br>';
    }

    public function getPage()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('parsing', 0);
        $criteria->order = 'rand()';
        $criteria->with = 'queriesPages';
        if ($this->se === self::SE_GOOGLE)
            $criteria->condition = 'queriesPages.google_position IS NULL';
        else
            $criteria->condition = 'queriesPages.yandex_position IS NULL';

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->query = Queries::model()->find($criteria);
            if ($this->query === null){
                $this->proxy->active = 0;
                $this->proxy->save();
                throw new CHttpException(404, 'Закончились кейворды.');
            }

            $this->query->parsing = 1;
            $this->query->save();
            $transaction->commit();
        }
        catch (Exception $e) {
            $transaction->rollback();
            $this->proxy->active = 0;
            $this->proxy->save();
            throw new CHttpException(404, 'Неудача при выбора кейворда для парсинга.');
        }

        echo $this->query->phrase.'<br>';
    }

    public function parseYandex()
    {
        $ch = curl_init('http://yandex.ru/yandsearch?text='.urlencode($this->query->phrase));
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy->value);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia1111");
        curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_PROXYTYPE, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function parseGoogle()
    {
        $ch = curl_init('http://www.google.ru/search?sclient=psy-ab&hl=ru&newwindow=1&site=&source=hp&q='.urlencode($this->query->phrase).'&btnG=Поиск');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy->value);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia1111");
        curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_PROXYTYPE, 5);
        /*curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);*/

        $result = curl_exec($ch);
        curl_close($ch);

        $document = phpQuery::newDocument($result);
        $links = array();
        foreach ($document->find('#ires li.g h3.r a.l') as $link) {
            $links [] = pq($link)->attr('href').'<br>';
        }
        if (empty($links))
            echo $result;
        var_dump($links);
        echo '<br>';
    }
}
