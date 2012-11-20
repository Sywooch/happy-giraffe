<?php
/**
 * Author: alexk984
 * Date: 05.10.12
 */

class SearchResultsParser extends ProxyParserThread
{
    /**
     * @var YandexSearchKeyword
     */
    public $query;

    public function start()
    {
        Yii::import('site.frontend.modules.cook.models.*');

        while (true) {
            $this->getQuery();
            $this->parseQuery();
            $this->closeQuery();

            if (Config::getAttribute('stop_threads') == 1)
                break;
        }
    }

    public function getQuery()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->log('load new keyword for parsing');
            $this->query = YandexSearchKeyword::model()->find($criteria);
            if ($this->query === null) {
                $this->closeThread('no queries');
            }

            $this->query->active = 1;
            $this->query->save();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            $this->closeThread('Fail with getting queries');
        }
    }

    public function parseQuery()
    {
        $query = $this->query->keyword->name;
        //if ($this->startsWith($query, 'http://'))

        $content = $this->query('http://yandex.ru/sitesearch?text=' . urlencode($query)
            . '&searchid='.SimilarArticlesParser::SITE_ID.'&reqenc=utf-8&l10n=ru&web=0&lr=38&numdoc=50');

        $document = phpQuery::newDocument($content);
        $links = array();
        foreach ($document->find('h3.b-serp-item__title a.b-serp-item__title-link') as $link) {
            $links [] = pq($link)->attr('href');
        }
        $document->unloadDocument();

        $pages = array();
        foreach ($links as $link)
            if (strpos($link, '?Comment_page=') === false) {
                $p = Page::model()->getOrCreate($link);
                if ($p !== null)
                    $pages[] = $p;
            }

        foreach ($pages as $page) {
            $model = new YandexSearchResult;
            $model->keyword_id = $this->query->keyword_id;
            $model->page_id = $page->id;
            $model->save();
        }
    }

    public function closeQuery()
    {
        $this->query->delete();
    }

    protected function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
}
