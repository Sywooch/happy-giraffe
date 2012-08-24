<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */
class IndexParserThread extends ProxyParserThread
{
    /**
     * @var IndexingUrl
     */
    public $url;
    /**
     * @var int search engine id
     */
    protected $pages = 10;
    public $up_id = null;

    function __construct()
    {
        parent::__construct();
        $up = IndexingUp::model()->find(array('order' => 'id desc'));
        $this->up_id = $up->id;
        $this->delay_min = 1;
        $this->delay_max = 1;
    }

    public function start()
    {
        while (true) {
            $this->getUrl();
            $this->parsePage();

            $this->url->active = 2;
            $this->url->save();
            $this->url = null;

            if (Config::getAttribute('stop_threads') == 1)
                break;

            sleep(10);
        }
    }

    public function perPage()
    {
        return 30;
    }

    public function getUrl()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);
        $criteria->compare('old', 0);
        $criteria->order = 'type DESC';

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->url = IndexingUrl::model()->find($criteria);
            if ($this->url === null) {
                $this->closeThread('no queries');
            }

            $this->url->active = 1;
            $this->url->save();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            $this->closeThread('Fail with getting queries');
        }
    }

    public function parsePage()
    {
        $links = $this->loadYandexPage();
        $this->log('Page loaded, links count: ' . count($links));

        $this->success_loads++;

        foreach ($links as $link)
            $this->saveUrl($link);

        if ($this->url->type == 1 && count($links) < $this->perPage())
            $this->checkNotFoundUrls();
    }

    private function loadYandexPage()
    {
        $content = $this->query('http://yandex.ru/yandsearch?text=' . urlencode('url:' . rtrim($this->url->url, '/') . '*') . '&numdoc=' . $this->perPage() . '&lr=38');

        if (strpos($content, 'Искомая комбинация слов нигде не встречается') !== false)
            return array();

        $document = phpQuery::newDocument($content);

        $links = array();
        foreach ($document->find('.b-body-items h2 a.b-serp-item__title-link') as $link) {
            $links [] = pq($link)->attr('href');
        }

        $document->unloadDocument();
        if (empty($links)) {
            $this->changeBadProxy();
            return $this->loadYandexPage();
        }

        return $links;
    }

    private function hasNextLink($document)
    {
        $el = $document->find('div.b-bottom-wizard div.b-pager span.b-pager__arrow:eq(1)');
        if (pq($el)->hasClass('b-pager__inactive'))
            return false;

        return true;
    }

    /**
     * Если в выдачу попали все урлы с частичным совпадением, значит остальные
     * с таким же совпадением урла не в индексе, помечаем их. Например по запросу
     * http://www.happy-giraffe.ru/community/1/forum/11*
     * найдено 5 урлов, значит остальные урлы, которые начинаются
     * на http://www.happy-giraffe.ru/community/1/forum/11
     * не в индексе
     */
    private function checkNotFoundUrls()
    {
        $count = IndexingUrl::model()->updateAll(array('active' => 2), 'url LIKE "' . $this->url->url . '%"');
        $this->log($count . ' urls excluded');
    }

    public function saveUrl($url)
    {
        $model = IndexingUrl::model()->findByAttributes(array('url' => $url));
        if ($model === null) {
            $model = new IndexingUrl;
            $model->url = $url;
        }
        $model->active = 2;
        $model->save();

        $upUrl = IndexingUpUrl::model()->findByAttributes(array(
            'up_id' => $this->up_id,
            'url_id' => $model->id,
        ));
        if ($upUrl === null) {
            $upUrl = new IndexingUpUrl;
            $upUrl->up_id = $this->up_id;
            $upUrl->url_id = $model->id;
            $upUrl->save();
        }
    }

    protected function closeThread($reason)
    {
        if ($this->url !== null) {
            $this->url->active = 0;
            $this->url->save();
        }
        parent::closeThread($reason);
    }
}
