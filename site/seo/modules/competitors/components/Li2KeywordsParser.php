<?php
/**
 * Author: alexk984
 * Date: 14.12.12
 */
class Li2KeywordsParser extends LiBaseParser
{
    const STATS_LIMIT = 0;
    const PERIOD_MONTH = 1;
    const PERIOD_DAY = 2;

    /**
     * @var LiSite
     */
    public $site = 1;
    public $parse_private = false;
    public $period = self::PERIOD_MONTH;

    public function start()
    {
        while ($this->site !== null) {
            $this->getSite();
            $this->log('Start parsing site ' . $this->site->id . ' ' . $this->site->url);

            $this->loadPage('http://www.liveinternet.ru/stat/');
            $this->loadPage('http://www.liveinternet.ru/stat/', 'LiveInternet',
                'url=' . urlencode('http://' . $this->site->url)
                    . '&password=' . (empty($this->site->password) ? '' : $this->site->password));
            $this->last_url = 'http://www.liveinternet.ru/stat/' . $this->site->url . '/index.html';

            $found = $this->parseStats();
            $this->log($this->site->url . ' - ' . $found);

            $this->site->active = 2;
            $this->site->save();
        }
        //mail('alexk984@gmail.com', 'report parsing site '.$this->site->url, $found.' keywords parsed');
    }

    public function getSite()
    {
        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $criteria = new CDbCriteria;
            if ($this->parse_private)
                $criteria->condition = 'password IS NOT NULL AND active=0';
            else
                $criteria->condition = 'public=1 AND active=0';

            $criteria->compare('type', LiSite::TYPE_LI);
            $this->site = LiSite::model()->find($criteria);

            if ($this->site === null)
                Yii::app()->end();

            $this->site->active = 1;
            $this->site->save();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            sleep(10);
            $this->getSite();
        }
    }

    public function parseStats()
    {
        $found = 0;
        $this->loadPage('http://www.liveinternet.ru/stat/' . $this->site->url . '/queries.html');

        if ($this->period == self::PERIOD_MONTH)
            $url = 'http://www.liveinternet.ru/stat/' . $this->site->url . '/queries.html?period=month;total=yes;&per_page=100;page=';
        else
            $url = 'http://www.liveinternet.ru/stat/' . $this->site->url . '/queries.html?per_page=100;page=';
        $result = $this->loadPage($url);

        $document = phpQuery::newDocument($result);
        $max_pages = $this->getPagesCount($document);
        $count = $this->ParseDocument($document);

        if ($count == 0)
            return false;

        for ($i = 2; $i <= $max_pages; $i++) {
            $page_url = $url . $i;
            $result = $this->loadPage($page_url);

            $document = phpQuery::newDocument($result);
            $count = $this->ParseDocument($document);
            $document->unloadDocument();

            if ($count == 0)
                break;
            if ($i % 10 == 0)
                $this->log("Page $i");

            $found += $count;
        }

        $this->log("Last page -  $i");
        $this->log("Found: $found");

        return $found;
    }

    public function getPagesCount($document)
    {
        $max_pages = 30;
        foreach ($document->find('table p a.high') as $link) {
            $name = trim(pq($link)->text());
            if (is_numeric($name))
                $max_pages = $name;
        }

        $this->log($max_pages . ' - pages count');

        return $max_pages;
    }

    private function ParseDocument($document)
    {
        $count = 0;
        foreach ($document->find('table table') as $table) {
            $text = pq($table)->find('td:first')->text();
            if (strstr($text, 'значения:суммарные') !== FALSE) {
                $i = 0;
                foreach (pq($table)->find('tr') as $tr) {
                    $i++;
                    if ($i < 2)
                        continue;
                    $keyword = trim(pq($tr)->find('td:eq(1)')->text());
                    if (empty($keyword) || $keyword == 'Не определена' || $keyword == 'Другие' || $keyword == 'сумма выбранных' || $keyword == 'всего')
                        continue;

                    Keyword::GetKeyword($keyword);
                    $count++;
                }
            }
        }

        return $count;
    }
}
