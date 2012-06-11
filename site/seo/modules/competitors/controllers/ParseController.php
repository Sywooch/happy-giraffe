<?php

class ParseController extends SController
{
    public $layout = 'main';
    public $cookie = 'pwd=1lwsZTdjVuTb2TFFwKo; suid=0IwZPl0hY8W_; per_page=100; adv-uid=d2ea12.d2608c.b9b2c0';

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

        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $error = $this->parseStats($site_id, $year, $month_from, $month_to, $mode);

        if ($error === true)
            echo CJSON::encode(array('status' => true));
        else
            echo CJSON::encode(array(
                'status' => false,
                'error' => $error
            ));
    }

    public function parseStats($site_id, $year, $month_from, $month_to, $mode)
    {
        $site = $this->loadModel($site_id);

        for ($month = $month_from; $month <= $month_to; $month++) {
            $url = 'http://www.liveinternet.ru/stat/' . $site->url
                . '/queries.html?date=' . $year . '-' . str_pad($month, 2, "0", STR_PAD_LEFT) . '-'
                . str_pad(cal_days_in_month(CAL_GREGORIAN, $month, $year), 2, '0', STR_PAD_LEFT)
                . Config::getAttribute('liveinternet-add-url')
                . '&period=month&total=yes&page=';

            $result = $this->loadPage($url, $url);

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
                $this->ParseDocument($document, $month, $year, $site_id);

                sleep(rand(1, 2));
            }
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

        if ($max_pages > 50)
            $max_pages = 50;

        return $max_pages;
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

    public function loadPage($page_url, $last_url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0');
        curl_setopt($ch, CURLOPT_URL, $page_url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_REFERER, $last_url);
        curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->getCookieFile());
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->getCookieFile());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
//        return $this->CP1251toUTF8($html);
    }

    public function getCookieFile()
    {
        $filename = Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR . 'liveinternet.txt';
        file_put_contents($filename, Config::getAttribute('liveinternet-cookie'));

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
                    $keyword_model = Keywords::GetKeyword($keyword);
                    SiteKeywordVisit::SaveValue($site_id, $keyword_model->id, $month, $year, str_replace(',', '', $stats));
                    $count++;
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