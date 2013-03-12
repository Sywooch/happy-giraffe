<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */

Yii::import('site.frontend.modules.cook.models.*');
class PositionParserThread extends ProxyParserThread
{
    const SE_YANDEX = 2;
    const SE_GOOGLE = 3;
    /**
     * @var ParsingPosition
     */
    protected $query;
    /**
     * @var int search engine id
     */
    protected $se;
    protected $pages = 20;

    function __construct($se, $debug = 0)
    {
        parent::__construct();
        $this->se = $se;
        $this->debug = $debug;
    }

    public function start()
    {
        while (true) {
            $this->getPage();
            $this->parsePage();
            $this->closeQuery();
        }
    }

    public function perPage()
    {
        if ($this->se == self::SE_GOOGLE)
            return 10;
        if ($this->se == self::SE_YANDEX)
            return 10;

        return 10;
    }

    public function getPage()
    {
        $criteria = new CDbCriteria;
        if ($this->se === self::SE_GOOGLE)
            $criteria->condition = 'google = 0';
        else
            $criteria->condition = 'yandex = 0';
        $criteria->compare('active', 0);

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->log('load new keyword for position parsing');
            $this->query = ParsingPosition::model()->find($criteria);
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

                if ($this->debug)
                    echo 'Page loaded, links count: ' . count($links) . "\n";

                if (empty($links))
                    $this->changeBadProxy();
            }
            $this->success_loads++;

            foreach ($links as $key => $link) {
                if ($this->startsWith($link, 'http://www.happy-giraffe.ru/')) {
                    $this->savePosition($link, $this->perPage() * $i + $key + 1);
                    $found = true;
                }
            }

            if ($found)
                break;
        }

        if (!$found) {
            $this->notFound();
        }
    }

    public function notFound()
    {
        //save 1000 position
        $search_phrases = PagesSearchPhrase::model()->findAllByAttributes(array('keyword_id' => $this->query->keyword->id));
        foreach ($search_phrases as $search_phrase)
            $this->savePhrasePosition($search_phrase->id, 1000);
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
        $content = $this->query('http://www.google.com/search?q=' . urlencode($this->query->keyword->name) . '&hl=ru&start=' . $start);

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
        $page = Page::model()->getOrCreate($url);
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

        $this->savePhrasePosition($search_phrase->id, $pos);
    }

    protected function savePhrasePosition($search_phrase_id, $pos)
    {
        $search_phrase_position = new SearchPhrasePosition();
        $search_phrase_position->se_id = $this->se;
        $search_phrase_position->search_phrase_id = $search_phrase_id;
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
            $this->query->google = 1;
        if ($this->se == self::SE_YANDEX)
            $this->query->yandex = 1;

        $this->query->active = 0;
        $this->query->save();
    }
}
