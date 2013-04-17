<?php
/**
 * Author: alexk984
 * Date: 14.12.12
 */
class Li2RubricParser extends LiBaseParser
{
    /**
     * @var LiSite
     */
    private $site = 1;
    private $rubrics;

    public function start()
    {
        $this->rubrics = LiSiteRubric::model()->findAll();

        while ($this->site !== null) {
            $this->getSite();
            //echo $this->site->url."\n";

            $this->loadPage('http://www.liveinternet.ru/stat/');
            $html = $this->loadPage('http://www.liveinternet.ru/stat/', 'LiveInternet',
                'url=' . urlencode('http://' . $this->site->url)
                    . '&password=' . (empty($this->site->password) ? '' : $this->site->password));
            $this->parseRubric($html);

            $this->site->active = 2;
            $this->site->save();
        }
        //mail('alexk984@gmail.com', 'report parsing site '.$this->site->url, $found.' keywords parsed');
    }

    public function getSite()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=' . LiSite::TYPE_LI . ' AND password IS NOT NULL AND rubric_id IS NULL AND active = 0';
        $criteria->offset = rand(1, 10);
        $this->site = LiSite::model()->find($criteria);
        $this->site->active = 1;
        $this->site->save();
    }

    public function parseRubric($html)
    {
        $document = phpQuery::newDocument($html);
        $link = $document->find('div:eq(3) a:eq(2)');
        $cat = trim(str_replace('/rating/ru/', '', pq($link)->attr('href')), '/');
        foreach ($this->rubrics as $rubric)
            if ($rubric->url == $cat) {
                $this->site->rubric_id = $rubric->id;
                $this->site->save();
            }
        if (empty($cat)) {
            $this->site->public = 0;
            $this->site->save();
        }
    }
}
