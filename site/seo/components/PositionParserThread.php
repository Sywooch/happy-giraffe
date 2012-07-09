<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */
class PositionParserThread extends ProxyParserThread
{
    const SE_YANDEX = 2;
    const SE_GOOGLE = 3;
    /**
     * @var Query
     */
    protected $query;
    /**
     * @var int search engine id
     */
    protected $se;
    protected $pages = 5;

    function __construct($se)
    {
        parent::__construct();
        $this->se = $se;
    }

    public function start()
    {
        while (true) {
            $this->getPage();
            $this->parsePage();
            $this->closeQuery();

            if (Config::getAttribute('stop_threads') == 1)
                break;
        }
    }

    public function perPage()
    {
        if ($this->se == self::SE_GOOGLE)
            return 10;
        if ($this->se == self::SE_YANDEX)
            return 20;

        return 10;
    }

    public function getPage()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 't.id asc';
        if ($this->se === self::SE_GOOGLE)
            $criteria->condition = 'google_parsed = 0';
        else
            $criteria->condition = 'yandex_parsed = 0';
        $criteria->compare('parsing', 0);
        $criteria->compare('week', date('W') - 1);

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->query = Query::model()->find($criteria);
            if ($this->query === null) {
                $this->closeThread('no queries');
            }

            $this->query->parsing = 1;
            $this->query->save();
            $transaction->commit();
        }
        catch (Exception $e) {
            $transaction->rollback();
            $this->closeThread('Fail with getting queries');
        }
    }

    public function parsePage()
    {
        for ($i = 0; $i < $this->pages; $i++) {
            $links = array();
            while (empty($links)) {
                if ($this->se == self::SE_GOOGLE)
                    $links = $this->loadGooglePage($i);
                if ($this->se == self::SE_YANDEX)
                    $links = $this->loadYandexPage($i);

                if ($this->debug)
                    echo 'Page loaded, links count: ' . count($links)."\n";

                if (empty($links))
                    $this->changeBadProxy();
            }
            $this->success_loads++;

            $found = false;
            foreach ($links as $key => $link) {
                if ($this->startsWith($link, 'http://www.happy-giraffe.ru/')) {
                    $this->savePosition($link, $this->perPage() * $i + $key + 1);
                    $found = true;
                }
            }

            if ($found)
                break;
        }
    }

    private function loadYandexPage($i)
    {
        $page = $i;
        $q = '';
        if ($page > 0)
            $q = '&p=' . $page;
        $content = $this->query('http://yandex.ru/yandsearch?text=' . urlencode($this->query->keyword->name) . '&zone=all&numdoc=' . $this->perPage() . '&lr=38&lang=ru' . $q);

        $document = phpQuery::newDocument($content);
        $links = array();
        foreach ($document->find('.b-body-items  h2 a.b-serp-item__title-link') as $link) {
            $links [] = pq($link)->attr('href');
        }

        $document->unloadDocument();

        return $links;
    }

    private function loadGooglePage($i)
    {
        $start = $i * $this->perPage();
        $content = $this->query('https://www.google.ru/search?q=' . urlencode($this->query->keyword->name) . '&btnG=%D0%9F%D0%BE%D0%B8%D1%81%D0%BA&hl=ru&newwindow=1&prmd=imvns&lr=lang_' . $this->country . '&gbv=2&country=' . $this->country . '&start=' . $start);

        $document = phpQuery::newDocument($content);
        $links = array();
        foreach ($document->find('#ires li.g div.vsc > h3.r > a.l') as $link) {
            $links [] = pq($link)->attr('href');
        }
        $document->unloadDocument();

        return $links;
    }

    public function savePosition($url, $pos)
    {
        $page = Page::model()->getOrCreate($url, $this->query->keyword->id);
        if ($page == null)
            return;
        $search_phrase = PagesSearchPhrase::model()->findByAttributes(array(
            'page_id' => $page->id,
            'keyword_id' => $this->query->keyword->id
        ));
        if ($search_phrase === null) {
            $search_phrase = new PagesSearchPhrase;
            $search_phrase->keyword_id = $this->query->keyword->id;
            $search_phrase->page_id = $page->id;
            $search_phrase->save();
        }

        $search_phrase_position = new SearchPhrasePosition();
        $search_phrase_position->se_id = $this->se;
        $search_phrase_position->search_phrase_id = $search_phrase->id;
        $search_phrase_position->position = $pos;
        $search_phrase_position->save();
    }

    protected function closeThread($reason)
    {
        parent::closeThread($reason);
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
