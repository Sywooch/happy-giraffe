<?php
/**
 * Author: alexk984
 * Date: 14.12.12
 */
class MailruSitesParser extends LiBaseParser
{
    public $page;

    public function start()
    {
        $this->rus_proxy = false;

        for ($this->page = 210; $this->page < 1000; $this->page++)
            $this->parsePage();
    }

    private function parsePage()
    {
        $html = $this->loadPage('http://top.mail.ru/Rating/All/Today/Visitors/' . $this->page . '.html', '@Mail.ru');
        $document = phpQuery::newDocument($html);

        $this->parseDocument($document);
    }

    private function parseDocument($document)
    {
        $count = 0;
        foreach ($document->find('form#select > table.Rating > tr') as $row) {
            $stat_url = pq($row)->find('td.l_col a:first')->attr('href');
            $stat_url = substr($stat_url, 9);
            $stat_url = trim($stat_url, '&');

            if (!empty($stat_url)) {
                $visits = pq($row)->find('td:eq(2) b')->text();
                $visits = str_replace(',', '', $visits);

                $public = (pq($row)->find('td:first a img')->attr('src') == '/i/stat.gif');
                $this->addSite($stat_url, $stat_url, $visits, $public);

                $count++;
            }
        }

        if ($count == 0){
            sleep(1);
            $this->changeProxy();
            return $this->parseDocument($document);
        }

        $this->log($count);
    }

    public function addSite($site_url, $stat_url, $visits, $public)
    {
        $this->log("$site_url - $stat_url - $visits - $public");

        if (LiSite::model()->exists('url="' . $stat_url . '"') == false) {
            $site = new LiSite();
            $site->site_url = $site_url;
            $site->url = $stat_url;
            $site->visits = $visits;
            $site->public = $public ? 1 : 0;
            $site->type = LiSite::TYPE_MAIL;
            $site->save();
        }
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
