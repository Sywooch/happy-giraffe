<?php

class MailParseController extends SController
{
    public $layout = '//layouts/empty';
    const STATS_LIMIT = 5;

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionParse()
    {
        $site_id = Yii::app()->request->getPost('site_id');
        $year = Yii::app()->request->getPost('year');
        $month_from = Yii::app()->request->getPost('month_from');
        $month_to = Yii::app()->request->getPost('month_to');

        if (empty($site_id))
            Yii::app()->end();

        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $error = $this->parseStats($site_id, $year, $month_from, $month_to);

        if ($error === true)
            echo CJSON::encode(array('status' => true));
        else
            echo CJSON::encode(array(
                'status' => false,
                'error' => $error
            ));
    }

    public function actionParse2()
    {
        $site_id = 63;

        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $this->parseStats($site_id, 2011, 1, 12, 0);
        $this->parseStats($site_id, 2012, 1, 11, 0);
    }

    public function parseStats($site_id, $year, $month_from, $month_to)
    {
        $site = $this->loadModel($site_id);

        for ($month = $month_from; $month <= $month_to; $month++) {
            $url = 'http://top.mail.ru/keywords?id='.$site->url.'&period=2&date=2012-'.$month.'-01&pp=200&gender=0&agegroup=0&searcher=all&sf=';

            $i = 0;
            $count = 1;
            while(!empty($count)){
                $page_url = $url . ($i*200);
                $result = $this->loadPage($page_url, '');

                $document = phpQuery::newDocument($result);
                $count = $this->ParseDocument($document, $month, $year, $site_id);

                sleep(1);
                $i++;
            }
        }

        return true;
    }

    public function loadPage($page_url, $last_url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:16.0) Gecko/20100101 Firefox/16.0');
        curl_setopt($ch, CURLOPT_URL, $page_url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        if (!empty($last_url))
            curl_setopt($ch, CURLOPT_REFERER, $last_url);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->getCookieFile());
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->getCookieFile());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = curl_exec($ch);
        curl_close($ch);

//        $result = iconv("Windows-1251","UTF-8",$result);

        return $result;
    }

    public function getCookieFile()
    {
        $filename = Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR . 'mailru.txt';

        return $filename;
    }

    private function ParseDocument($document, $month, $year, $site_id)
    {
        $count = 0;
        foreach ($document->find('div.listing_projects table.t1 tr') as $row) {
            $keyword = trim(pq($row)->find('td:eq(2)')->text());
            if (empty($keyword) || $keyword == 'другие запросы')
                continue;

            $keyword = substr($keyword, 3);
            echo $keyword."\n";

            $stats = trim(pq($row)->find('td:eq(0)')->text());
            $stats = str_replace(',', '', $stats);
            if ($stats < self::STATS_LIMIT)
                return false;

            $keyword_model = Keyword::GetKeyword($keyword);
            if ($keyword_model !== null){
                SiteKeywordVisit::SaveValue($site_id, $keyword_model->id, $month, $year, $stats);
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