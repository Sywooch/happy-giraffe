<?php
/**
 * Author: alexk984
 * Date: 14.12.12
 */
class MailruKeywordsParser extends LiBaseParser
{
    const STATS_LIMIT = 0;
    /**
     * @var LiSite
     */
    public $site = 1;

    public function start()
    {
        $this->rus_proxy = false;

        while ($this->site !== null) {
            $this->getSite();
            $this->log('Start parsing site ' . $this->site->id . ' ' . $this->site->url);

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
            $criteria->condition = 'public=1 AND active=0';
            $criteria->compare('type', LiSite::TYPE_MAIL);
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

        $url = 'http://top.mail.ru/keywords?id=' . $this->site->url . '&period=2&date=' . date("Y-m-d")  . '&pp=200&gender=0&agegroup=0&searcher=all&sf=';
        for ($i = 0; $i <= 6; $i++) {
            $page_url = $url . ($i * 200);
            $result = $this->loadPage($page_url, '@Mail.ru');

            $document = phpQuery::newDocument($result);
            $count = $this->ParseDocument($document);
            $found += $count;
            if ($count == 0)
                break;

            sleep(3);
        }

        return $found;
    }

    private function ParseDocument($document)
    {
        $count = 0;
        foreach ($document->find('div.listing_projects table.t1 tr') as $row) {
            $keyword = trim(pq($row)->find('td:eq(2)')->text());
            if (empty($keyword) || $keyword == 'другие запросы')
                continue;

            $keyword = trim(substr($keyword, 3));
            Keyword::GetKeyword($keyword);
            $count++;
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
