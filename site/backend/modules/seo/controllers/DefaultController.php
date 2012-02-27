<?php

class DefaultController extends BController
{
    public $section = 'seo';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('seo'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex($site_id = 1)
    {
        $model = new SeoKeyStats;
        $model->site_id = $site_id;

        $this->render('index', array(
            'model' => $model,
            'site_id'=>$site_id
        ));
    }

    public function actionCalc()
    {
        $keywords = SeoKeywords::model()->with(array('seoStats'))->findAll();
        $sites = SeoSite::model()->findAll();
        foreach ($sites as $site) {
            foreach ($keywords as $keyword) {
                $models = SeoStats::model()->findAll('site_id = ' . $site->id . ' AND keyword_id = ' . $keyword->id);

                $stat = SeoKeyStats::model()->find('site_id = ' . $site->id . ' AND keyword_id = ' . $keyword->id);
                if ($stat === null) {
                    $stat = new SeoKeyStats;
                    $stat->keyword_id = $keyword->id;
                    $stat->site_id = $site->id;
                }
                foreach ($models as $model) {
                    $stat->setAttribute('m' . $model->month, $model->value);
                }

                $stat->save();
            }
        }
    }

    public function actionParseStats()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery.phpQuery');
        $site_id = 1;
        $year = 2011;

        for ($month = 12; $month > 0; $month--) {
            $url = 'http://www.liveinternet.ru/stat/blog.mosmedclinic.ru/queries.html?date=2011-' . $month . '-' . cal_days_in_month(CAL_GREGORIAN, $month, $year) . ';period=month;total=yes;page=';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_COOKIE, 'session=07GdsQ0tOczS; suid=0HL2kG3LzWGy; per_page=100; total=yes; adv-uid=7e07e5.49d318.696d42');
            //curl_setopt($ch, CURLOPT_COOKIE, 'pwd=1sd9Cw4MQjmNOt3lYV6; suid=0HL2kG3LzWGy; per_page=100; total=yes; adv-uid=7e07e5.49d318.696d42');
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
            $res = array_merge(array(), $this->GetStat($document, $month, $year, $site_id));
            flush();
            sleep(5);

            for ($i = 2; $i <= $max_pages; $i++) {
                $page_url = $url . $i;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $page_url);
                curl_setopt($ch, CURLOPT_FAILONERROR, 1);
                curl_setopt($ch, CURLOPT_COOKIE, 'session=07GdsQ0tOczS; suid=0HL2kG3LzWGy; per_page=100; total=yes; adv-uid=7e07e5.49d318.696d42');
                //curl_setopt($ch, CURLOPT_COOKIE, 'pwd=1sd9Cw4MQjmNOt3lYV6; suid=0HL2kG3LzWGy; per_page=100; total=yes; adv-uid=7e07e5.49d318.696d42');
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

    public function actionParseStats2()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery.phpQuery');
        $site_id = 3;
        $year = 2011;

        $url = 'http://www.liveinternet.ru/stat/shkolazhizni/queries.html?date=2011-12-31;period=month;';
        for ($month = 12; $month > 0; $month--) {
            $last_url = $url;
            $url = 'http://www.liveinternet.ru/stat/shkolazhizni/queries.html?date=2011-' . $month . '-' . cal_days_in_month(CAL_GREGORIAN, $month, $year) . ';period=month;page=';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_REFERER, $last_url);
            curl_setopt($ch, CURLOPT_COOKIE, 'suid=0HL2kG3LzWGy; per_page=100; total=yes; adv-uid=7e07e5.49d318.696d42');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s

            $useragent="Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2";
            curl_setopt($ch, CURLOPT_USERAGENT, $useragent);

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
            $res = array_merge(array(), $this->GetStat($document, $month, $year, $site_id));
            flush();
            sleep(5);

            for ($i = 2; $i <= $max_pages; $i++) {
                $page_url = $url . $i;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $page_url);
                curl_setopt($ch, CURLOPT_FAILONERROR, 1);
                curl_setopt($ch, CURLOPT_REFERER, $last_url);
                curl_setopt($ch, CURLOPT_COOKIE, 'suid=0HL2kG3LzWGy; per_page=100; total=yes; adv-uid=7e07e5.49d318.696d42');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
                curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
                $result = curl_exec($ch); // run the whole process
                curl_close($ch);

                $document = phpQuery::newDocument($result);
                $res = array_merge($res, $this->GetStat($document, $month, $year, $site_id));

                flush();
                sleep(rand(3, 7));
            }
        }
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
                    if (empty($keyword))
                        break;
                    $stats = trim(pq($tr)->find('td:eq(2)')->text());
                    $res[] = array($keyword, $stats);
                    //                    echo $keyword . ' ' . $stats . '<br>';
                    $keyword_model = SeoKeywords::GetKeyword($keyword);
                    $model = new SeoStats();
                    $model->month = $month;
                    $model->year = $year;
                    $model->keyword_id = $keyword_model->id;
                    $model->value = str_replace(',', '', $stats);
                    $model->site_id = $site_id;
                    $model->SaveOrUpdate();
                }

                echo $i.'<br>';
            }
        }

        return $res;
    }
}