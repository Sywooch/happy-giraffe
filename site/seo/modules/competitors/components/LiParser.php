<?php
/**
 * Author: alexk984
 * Date: 14.12.12
 */
class LiParser extends LiBaseParser
{
    const STATS_LIMIT = 5;
    /**
     * @var Site
     */
    public $site;

    public function start($site_id, $year, $month_from, $month_to)
    {
        $this->site = $this->loadModel($site_id);
        $this->log('Start parsing site '.$this->site->id.' '.$this->site->name);

        if (!empty($this->site->password))
            $this->Login();
        else{
            $this->loadPage('http://www.liveinternet.ru/stat/');
            $this->loadPage('http://www.liveinternet.ru/stat/', 'LiveInternet', 'url='.urlencode('http://'.$this->site->url).'&password=');
            $this->last_url = 'http://www.liveinternet.ru/stat/'.$this->site->url.'/index.html';
        }

        $found = $this->parseStats($year, $month_from, $month_to);
        $this->log($site_id.' - '.$found);
        //mail('alexk984@gmail.com', 'report parsing site '.$this->site->url, $found.' keywords parsed');
    }


    public function Login()
    {
        $html = $this->loadPage('http://www.liveinternet.ru/stat/');
        $document = phpQuery::newDocument($html);

        //parse rnd
        $rnd = $document->find('input[name=rnd]');
        $rnd = pq($rnd)->attr('value');

        $post = 'rnd='.$rnd.'&url='.urlencode('http://'.$this->site->url).'&password='.$this->site->password.'&keep_password=on&ok=+OK+';
        $this->loadPage('http://www.liveinternet.ru/stat/', 'LiveInternet', $post);
    }


    public function parseStats($year, $month_from, $month_to)
    {
        $found = 0;

        $this->loadPage('http://www.liveinternet.ru/stat/' . $this->site->url . '/queries.html');
        $this->loadPage('http://www.liveinternet.ru/stat/' . $this->site->url . '/queries.html?total=yes&period=month');

        for ($month = $month_to; $month >= $month_from; $month--) {
            $url = 'http://www.liveinternet.ru/stat/' . $this->site->url
                . '/queries.html?date=' . $year . '-' . str_pad($month, 2, "0", STR_PAD_LEFT) . '-'
                . str_pad(cal_days_in_month(CAL_GREGORIAN, $month, $year), 2, '0', STR_PAD_LEFT)
                . '&period=month&total=yes&per_page=100&page=';

            $result = $this->loadPage($url);

            $document = phpQuery::newDocument($result);
            $max_pages = $this->getPagesCount($document);
            $count = $this->ParseDocument($document, $month, $year);

            if ($count == 0){
                return "Data not found on page - \n" . $url."\n";
            }

            for ($i = 2; $i <= $max_pages; $i++) {
                $page_url = $url . $i;
                $result = $this->loadPage($page_url);

                $document = phpQuery::newDocument($result);
                $count = $this->ParseDocument($document, $month, $year);
                if ($count == 0)
                    break;
                if ($i % 10 == 0)
                    $this->log("Page $i");

                $found += $count;
            }

            $this->log("Last page -  $i");
            $this->log("Year $year, Month $month - $found");
        }

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

        return $max_pages;
    }

    private function ParseDocument($document, $month, $year)
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
                    if (empty($keyword) || $keyword == 'Не определена' || $keyword == 'Другие'
                        || $keyword == 'сумма выбранных' || $keyword == 'всего'
                    )
                        continue;

                    $stats = trim(pq($tr)->find('td:eq(2)')->text());
                    $stats = str_replace(',', '', $stats);
                    if ($stats < self::STATS_LIMIT)
                        return false;

                    $keyword_model = Keyword::GetKeyword($keyword);
                    if ($keyword_model !== null) {
                        SiteKeywordVisit::SaveValue($this->site->id, $keyword_model->id, $month, $year, $stats);
                        $count++;
                    }
                }
            }
        }

        return $count;
    }


    /**
     * @param int $id model id
     * @return Site
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Site::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
