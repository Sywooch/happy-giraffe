<?php

class ParseController extends BController
{
    public $section = 'seo';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('seo'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionParseStats()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $site_id = 1;
        $year = 2012;

        $cookie = 'session=07VU3n1Nd8cs; suid=0HL0At2P9XWy; pwd=1J-ABQaL7zYTCNkUN5U; per_page=100; total=yes; adv-uid=9967d7.2d8efb.e7f5';
        $site = 'baby.ru';
        ob_start();

        for ($month = 4; $month > 2; $month--) {
            $url = 'http://www.liveinternet.ru/stat/' . $site . '/queries.html?date=' . $year . '-' . $month . '-' . cal_days_in_month(CAL_GREGORIAN, $month, $year) . ';period=month;total=yes;page=';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
            $result = curl_exec($ch); // run the whole process
            curl_close($ch);

            $document = phpQuery::newDocument($result);
            $max_pages = 30;
            foreach ($document->find('table p a.high') as $link) {
                $name = trim(pq($link)->text());
                if (is_numeric($name))
                    $max_pages = $name;
            }
            echo $max_pages . '<br>';
            if ($max_pages > 40)
                $max_pages = 40;
            $this->GetStat($document, $month, $year, $site_id);
            ob_flush();
            flush();
            sleep(2);

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
                $this->GetStat($document, $month, $year, $site_id);

                ob_flush();
                flush();
                sleep(rand(1, 2));
            }
        }
    }

    public function actionParsePages()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $site_id = 1;
        $year = 2012;

        $cookie = 'session=07VU3n1Nd8cs; suid=0HL0At2P9XWy; pwd=1J-ABQaL7zYTCNkUN5U; per_page=100; total=yes; adv-uid=9967d7.2d8efb.e7f5';
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
                    $model = new SeoPagesStats();
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
                    $page = SeoVisitsNames::GetVisitName($keyword);
                    $model = new SeoVisits();
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
                    $page = SeoBrowser::GetModelName($keyword);
                    $model = new SeoBrowserStats();
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
    }

    public function actionParseStats2()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $site_id = 3;
        $year = 2012;

        $cookie = 'suid=0HL0At2P9XWy; per_page=100; total=yes; adv-uid=9967d7.2d8efb.e7f5';
        $url = 'http://www.liveinternet.ru/stat/shkolazhizni/queries.html?date=2011-12-31;period=month;';
        for ($month = 3; $month > 0; $month--) {
            $last_url = $url;
            $url = 'http://www.liveinternet.ru/stat/shkolazhizni/queries.html?date=' . $year . '-' . $month . '-' . cal_days_in_month(CAL_GREGORIAN, $month, $year) . ';period=month;page=';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_REFERER, $last_url);
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s

            $result = curl_exec($ch); // run the whole process
            curl_close($ch);

            $document = phpQuery::newDocument($result);
            $max_pages = 30;
            foreach ($document->find('table p a.high') as $link) {
                $name = trim(pq($link)->text());
                if (is_numeric($name))
                    $max_pages = $name;
            }
            if ($max_pages > 50)
                $max_pages = 50;

            echo $max_pages . '<br>';
            $res = array_merge(array(), $this->GetStat($document, $month, $year, $site_id));
            flush();
            sleep(2);

            for ($i = 2; $i <= $max_pages; $i++) {
                $page_url = $url . $i;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $page_url);
                curl_setopt($ch, CURLOPT_FAILONERROR, 1);
                curl_setopt($ch, CURLOPT_REFERER, $last_url);
                curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
                curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
                $result = curl_exec($ch); // run the whole process
                curl_close($ch);

                $document = phpQuery::newDocument($result);
                $res = array_merge($res, $this->GetStat($document, $month, $year, $site_id));

                flush();
                sleep(rand(1, 2));
            }
        }
    }

    public function loadPage($url)
    {
        $curl = curl_init();

        // Setup headers - I used the same headers from Firefox version 2.0.0.6
        // below was split up because php.net said the line was too long. :/
        $header[0] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8;";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Content-Type: text/html; charset=windows-1251";
        $header[] = "Accept-Language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3";
        $header[] = "Pragma: "; // browsers keep this blank.

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
//        curl_setopt($curl, CURLOPT_PROXY, '176.196.169.3:8080');

        $html = curl_exec($curl); // execute the curl command
        curl_close($curl); // close the connection

        return $html;
//        return $this->CP1251toUTF8($html);
    }

    private function GetStat($document, $month, $year, $site_id)
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
                    $keyword = trim(pq($tr)->find('td:eq(1)')->text());
                    if (empty($keyword) || $keyword == 'Не определена' || $keyword == 'Другие')
                        continue;
                    $stats = trim(pq($tr)->find('td:eq(2)')->text());
                    $res[] = array($keyword, $stats);
                    //                    echo $keyword . ' ' . $stats . '<br>';
                    $keyword_model = Keywords::GetKeyword($keyword);
                    $model = new Stats();
                    $model->month = $month;
                    $model->year = $year;
                    $model->keyword_id = $keyword_model->id;
                    $model->value = str_replace(',', '', $stats);
                    $model->site_id = $site_id;
                    $model->SaveOrUpdate();
                }

                echo $i . '<br>';
            }
        }

        return $res;
    }
}