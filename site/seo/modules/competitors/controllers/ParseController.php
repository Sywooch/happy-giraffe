<?php

class ParseController extends SController
{
    public $layout = '//layouts/empty';
    const STATS_LIMIT = 3;

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
        $mode = Yii::app()->request->getPost('mode');

        if (empty($site_id))
            Yii::app()->end();

        $error = $this->parseStats($site_id, $year, $month_from, $month_to, $mode);

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
        $site_id = 1;

        $this->parseStats($site_id, 2012, 11, 12, 0);
//        for($site_id=14;$site_id<40;$site_id++){
//        $this->parseStats($site_id, 2012, 1, 12, 0);
//        }
    }

    public function parseStats($site_id, $year, $month_from, $month_to, $mode)
    {
        $site = $this->loadModel($site_id);

        $this->loadPage('http://www.liveinternet.ru/stat/' . $site->url . '/index.html', '');
        $this->loadPage('http://www.liveinternet.ru/stat/' . $site->url . '/queries.html', 'http://www.liveinternet.ru/stat/' . $site->url . '/index.html');
        $next_url = 'http://www.liveinternet.ru/stat/' . $site->url . '/queries.html?total=yes&period=month';
        $this->loadPage($next_url, 'http://www.liveinternet.ru/stat/' . $site->url . '/queries.html');

        for ($month = $month_from; $month <= $month_to; $month++) {
            $url = 'http://www.liveinternet.ru/stat/' . $site->url
                . '/queries.html?date=' . $year . '-' . str_pad($month, 2, "0", STR_PAD_LEFT) . '-'
                . str_pad(cal_days_in_month(CAL_GREGORIAN, $month, $year), 2, '0', STR_PAD_LEFT)
                . '&period=month&total=yes&per_page=100&page=';

            $result = $this->loadPage($url, $next_url);
            if ($mode == 2) {
                echo $result;
                Yii::app()->end();
            }

            $document = phpQuery::newDocument($result);
            $max_pages = $this->getPagesCount($document);
            $count = $this->ParseDocument($document, $month, $year, $site_id);

            if ($count == 0)
                return 'Не найдено данных на стрaнице - ' . $url;
            sleep(rand(1, 2));

            for ($i = 2; $i <= $max_pages; $i++) {
                $page_url = $url . $i;
                $result = $this->loadPage($page_url, $url);

                $document = phpQuery::newDocument($result);
                if ($this->ParseDocument($document, $month, $year, $site_id) === false)
                    break;

                sleep(rand(1, 2));
            }

            $next_url = $url;
        }

        return true;
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

        return $result;
//        return $this->CP1251toUTF8($html);
    }

    public function getCookieFile()
    {
        $filename = Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR . 'liveinternet.txt';

        return $filename;
    }

    private function ParseDocument($document, $month, $year, $site_id)
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
                        SiteKeywordVisit::SaveValue($site_id, $keyword_model->id, $month, $year, $stats);
                        $count++;
                    }
                }
            }
        }

        return $count;
    }

    public function actionExport()
    {
        $sites = range(88, 94);
        foreach ($sites as $site_id) {
            $criteria = new CDbCriteria;
            $criteria->compare('site_id', $site_id);
            //$criteria->compare('year', 2011);
            $criteria->limit = 100;
            $criteria->offset = 0;
            $criteria->with = array('keyword');

            $i = 0;
            $models = array(0);
            while (!empty($models)) {
                $models = SiteKeywordVisit::model()->findAll($criteria);

                foreach ($models as $model) {
                    $model2 = new SitesKeywordsVisit2();
                    $model2->attributes = $model->attributes;
                    if (isset($model->keyword->name)) {
                        $model2->keyword = $model->keyword->name;
                        $model2->save();
                    }
                }

                $i++;
                $criteria->offset = $i * 100;
            }
        }
    }

    public function actionImport()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = SitesKeywordsVisit2::model()->findAll($criteria);

            foreach ($models as $model) {
                $model2 = new SiteKeywordVisit();
                $model2->attributes = $model->attributes;
                $model2->keyword_id = Keyword::GetKeyword($model->keyword)->id;
                $model2->save();
            }

            $criteria->offset += 100;
        }
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


    /*public function actionParsePages()
{
    Yii::import('site.frontend.extensions.phpQuery.phpQuery');
    $site_id = 1;
    $year = 2012;

    $cookie = 'session=07VU3n1Nd8cs; suid=0HL0At2P9XWy; pwd=1njOHUeRvpWhhIViv; per_page=100; total=yes; adv-uid=bb2c2c';
    $site = 'baby.ru';
    ob_start();

    for ($month = 3; $month > 0; $month--) {
        $url = 'http://www.liveinternet.ru/stat/' . $site . '/pages.html?date=' . $year . '-' . $month . '-' . cal_days_in_month(CAL_GREGORIAN, $month, $year) . ';period=month;total=yes;page=';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
        $result = curl_exec($ch); // run the whole process
        curl_close($ch);

        $document = phpQuery::newDocument($result);
        $max_pages = 200;
        foreach ($document->find('table p a.high') as $link) {
            $name = trim(pq($link)->text());
            if (is_numeric($name))
                $max_pages = $name;
        }
        echo $max_pages . '<br>';
        if ($max_pages > 400)
            $max_pages = 400;
        $this->SavePages($document, $month, $year, $site_id);
        sleep(1);

        for ($i = 2; $i <= $max_pages; $i++) {
            $page_url = $url . $i;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $page_url);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
            $result = curl_exec($ch); // run the whole process
            curl_close($ch);

            $document = phpQuery::newDocument($result);
            $this->SavePages($document, $month, $year, $site_id);

            sleep(rand(1, 2));
        }
    }
}

private function SavePages($document, $month, $year, $site_id, $first_page = 0)
{
    $res = array();
    foreach ($document->find('table table') as $table) {
        $text = pq($table)->find('td:first')->text();
        //            echo $text.'<br>';
        if (strstr($text, 'значения:суммарные') !== FALSE) {
            $i = 0;
            foreach (pq($table)->find('tr') as $tr) {
                $i++;
                if ($i < 2)
                    continue;
                $keyword = trim(pq($tr)->find('td:eq(1) label a')->attr('href'));
                //echo $keyword.'<br>';
                if (empty($keyword))
                    continue;
                $stats = trim(pq($tr)->find('td:eq(2)')->text());
                $res[] = array($keyword, $stats);
                $page = SitePages::GetPage($keyword);
                $model = new SitePageVisit();
                $model->setAttribute('m' . $month, str_replace(',', '', $stats));
                $model->year = $year;
                $model->page_id = $page->id;
                $model->first_page = $first_page;
                $model->site_id = $site_id;
                $model->SaveOrUpdate($month);
            }

            echo $i . '<br>';
        }
    }

    return $res;
}

public function actionParseFirstPages()
{
    Yii::import('site.frontend.extensions.phpQuery.phpQuery');
    $site_id = 1;
    $year = 2012;

    $cookie = 'session=07VU3n1Nd8cs; suid=0HL0At2P9XWy; pwd=1J-ABQaL7zYTCNkUN5U; per_page=100; total=yes; adv-uid=9967d7.2d8efb.e7f5';
    $site = 'baby.ru';
    ob_start();

    for ($month = 3; $month > 0; $month--) {
        $url = 'http://www.liveinternet.ru/stat/' . $site . '/first_pages.html?date=' . $year . '-' . $month . '-' . cal_days_in_month(CAL_GREGORIAN, $month, $year) . ';period=month;total=yes;page=';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
        $result = curl_exec($ch); // run the whole process
        curl_close($ch);

        $document = phpQuery::newDocument($result);
        $max_pages = 200;
        foreach ($document->find('table p a.high') as $link) {
            $name = trim(pq($link)->text());
            if (is_numeric($name))
                $max_pages = $name;
        }
        echo $max_pages . '<br>';
        if ($max_pages > 400)
            $max_pages = 400;
        $this->SavePages($document, $month, $year, $site_id, 1);

        for ($i = 2; $i <= $max_pages; $i++) {
            $page_url = $url . $i;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $page_url);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
            $result = curl_exec($ch); // run the whole process
            curl_close($ch);

            $document = phpQuery::newDocument($result);
            $this->SavePages($document, $month, $year, $site_id, 1);

        }
    }
}

public function actionParseVisits()
{
    Yii::import('site.frontend.extensions.phpQuery.phpQuery');
    $site_id = 1;
    $year = 2012;
    $month = 3;

    $cookie = 'session=07VU3n1Nd8cs; suid=0HL0At2P9XWy; pwd=1J-ABQaL7zYTCNkUN5U; per_page=100; total=yes; adv-uid=9967d7.2d8efb.e7f5';
    $site = 'baby.ru';
    ob_start();

    for ($day = 5; $day <= 31; $day++) {
        $url = 'http://www.liveinternet.ru/stat/' . $site . '/index.html?date=' . $year . '-' . $month . '-' . $day . ';period=day;page=';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
        $result = curl_exec($ch); // run the whole process
        curl_close($ch);

        $document = phpQuery::newDocument($result);
        $this->SaveVisits($document, $month, $year, $site_id, $day);
    }
}

private function SaveVisits($document, $month, $year, $site_id, $day)
{
    $res = array();
    foreach ($document->find('table table') as $table) {
        $text = pq($table)->find('tr:eq(1) td:eq(1)')->text();
        if (strstr($text, 'Просмотры') !== FALSE) {
            $i = 0;
            foreach (pq($table)->find('tr') as $tr) {
                $i++;
                if ($i < 2)
                    continue;
                $keyword = trim(pq($tr)->find('td:eq(1)')->text());
                echo $keyword . '<br>';
                if (empty($keyword))
                    continue;
                $stats = trim(pq($tr)->find('td:eq(2)')->text());
                $res[] = array($keyword, $stats);
                $page = SiteStatisticType::GetVisitName($keyword);
                $model = new SiteStatistic();
                $model->value = str_replace(',', '', $stats);
                $model->year = $year;
                $model->month = $month;
                $model->day = $day;
                $model->visit_name_id = $page->id;
                $model->site_id = $site_id;
                $model->SaveOrUpdate();
            }

            echo $i . '<br>';
        }
    }

    return $res;
}

public function actionParseBrowsers()
{
    Yii::import('site.frontend.extensions.phpQuery.phpQuery');
    $site_id = 1;
    $year = 2012;

    $cookie = 'session=07VU3n1Nd8cs; suid=0HL0At2P9XWy; pwd=1J-ABQaL7zYTCNkUN5U; per_page=100; total=yes; adv-uid=9967d7.2d8efb.e7f5';
    $site = 'baby.ru';
    ob_start();

    for ($month = 2; $month <= 3; $month++) {
        $url = 'http://www.liveinternet.ru/stat/' . $site . '/browsers.html?date=' . $year . '-' . $month . '-' . cal_days_in_month(CAL_GREGORIAN, $month, $year) . ';period=month;page=';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
        $result = curl_exec($ch); // run the whole process
        curl_close($ch);

        $document = phpQuery::newDocument($result);
        $this->SaveBrowsers($document, $month, $year, $site_id);
    }
}

private function SaveBrowsers($document, $month, $year, $site_id)
{
    $res = array();
    foreach ($document->find('table table') as $table) {
        $text = pq($table)->find('td:first')->text();
        if (strstr($text, 'значения:среднесуточные') !== FALSE) {
            $i = 0;
            foreach (pq($table)->find('tr') as $tr) {
                $i++;
                if ($i < 2)
                    continue;
                $keyword = trim(pq($tr)->find('td:eq(1)')->text());
                //echo $keyword.'<br>';
                if (empty($keyword))
                    continue;
                $stats = trim(pq($tr)->find('td:eq(2)')->text());
                $res[] = array($keyword, $stats);
                $page = SiteBrowser::GetModelName($keyword);
                $model = new SiteBrowserVisit();
                $model->value = str_replace(',', '', $stats);
                $model->year = $year;
                $model->month = $month;
                $model->browser_id = $page->id;
                $model->site_id = $site_id;
                $model->SaveOrUpdate();
            }

            echo $i . '<br>';
        }
    }

    return $res;
}*/
}