<?php
/**
 * Author: alexk984
 * Date: 14.12.12
 */
class MailruParser extends LiBaseParser
{
    const STATS_LIMIT = 0;
    /**
     * @var Site
     */
    public $site;

    public function start($site_id, $year, $month_from, $month_to)
    {
        $this->site = $this->loadModel($site_id);
        $this->log('Start parsing site ' . $this->site->id . ' ' . $this->site->name);

        $found = $this->parseStats($year, $month_from, $month_to);
        $this->log($site_id . ' - ' . $found);
        //mail('alexk984@gmail.com', 'report parsing site '.$this->site->url, $found.' keywords parsed');
    }

    public function parseStats($year, $month_from, $month_to)
    {
        $found = 0;

        for ($month = $month_from; $month <= $month_to; $month++) {
            $url = 'http://top.mail.ru/keywords?id=' . $this->site->url . '&period=2&date=' . $year . '-' . $month . '-01&pp=200&gender=0&agegroup=0&searcher=all&sf=';

            for ($i = 0; $i <= 6; $i++) {
                $page_url = $url . ($i * 200);
                $result = $this->loadPage($page_url, '@Mail.ru');

                $document = phpQuery::newDocument($result);
                $count = $this->ParseDocument($document, $month, $year);
                $found += $count;
                if ($count == 0)
                    break;
            }
        }

        return $found;
    }

    private function ParseDocument($document, $month, $year)
    {
        $count = 0;
        foreach ($document->find('div.listing_projects table.t1 tr') as $row) {
            $keyword = trim(pq($row)->find('td:eq(2)')->text());
            if (empty($keyword) || $keyword == 'другие запросы')
                continue;

            $keyword = trim(substr($keyword, 3));

            $stats = trim(pq($row)->find('td:eq(0)')->text());
            $stats = str_replace(',', '', $stats);
            if ($stats < self::STATS_LIMIT)
                return false;

            $keyword_model = Keyword::GetKeyword($keyword);
            if ($keyword_model !== null) {
                SiteKeywordVisit::SaveValue($this->site->id, $keyword_model->id, $month, $year, $stats);
                $count++;
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
