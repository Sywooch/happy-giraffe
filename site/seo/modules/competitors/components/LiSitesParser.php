<?php
/**
 * Author: alexk984
 * Date: 14.12.12
 */
class LiSitesParser extends LiBaseParser
{
    public $start_page;
    public $page;

    public function start($start_page = 1)
    {
        $this->start_page = $start_page;
        $this->page = $start_page;

        for ($this->page = $start_page; $this->page < $start_page + 100; $this->page++)
            $this->parsePage();
    }

    private function parsePage()
    {
        $html = $this->loadPage('http://www.liveinternet.ru/rating/ru/index.html?page=' . $this->page);
        $document = phpQuery::newDocument($html);

        $this->parseDocument($document);
    }

    private function parseDocument($document)
    {
        $count = 0;
        foreach ($document->find('table[cellpadding="5"]') as $table) {
            foreach (pq($table)->find('tr') as $row) {
                $site_url = pq($row)->find('a:first')->attr('href');
                if (!empty($site_url)) {

                    $stat_url = pq($row)->find('a:eq(1)')->attr('href');
                    $stat_url = str_replace('/stat/', '', $stat_url);
                    $stat_url = trim($stat_url, '/');

                    $visits = pq($row)->find('td:eq(2)')->text();
                    $visits = str_replace(',', '', $visits);

                    $public = (pq($row)->find('td:eq(3) img')->attr('src') == 'http://i.li.ru/i/stat_public.gif');
                    if ($public)
                        $public = $this->checkPhrasesPublicity($stat_url);

                    $this->addSite($site_url, $stat_url, $visits, $public);

                    $count++;
                }
            }
        }

        $this->log($count);
    }

    public function addSite($site_url, $stat_url, $visits, $public)
    {
        $this->log("$site_url - $stat_url - $visits - <b>$public</b> <br>");

        if (LiSite::model()->exists('url="' . $stat_url . '"') == false) {
            $site = new LiSite();
            $site->site_url = $site_url;
            $site->url = $stat_url;
            $site->visits = $visits;
            $site->public = $public ? 1 : 0;
            $site->save();
        }
    }

    private function checkPhrasesPublicity($stat_url)
    {
        $html = $this->loadPage('http://www.liveinternet.ru/stat/' . $stat_url . '/');
        return strpos($html, '<a href="queries.html">по поисковым фразам</a>') !== false;
    }


    /**
     * @param int $id model id
     * @return Site
     * @throws CException
     */
    public function loadModel($id)
    {
        $model = LiSite::model()->findByPk($id);
        if ($model === null)
            throw new CException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
