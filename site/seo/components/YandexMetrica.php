<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */
class YandexMetrica
{
    public $token = 'b1cb78403f76432b8a6803dc5e6631b5';
    public $min_visits = 4;
    public $date1;
    public $date2;

    function __construct()
    {
        $this->min_visits = Config::getAttribute('minClicks');
        $this->date1 = date("Ymd", strtotime('-1 month'));
        $this->date2 = date("Ymd");
    }

    public function parseQueries()
    {
        $next = 'http://api-metrika.yandex.ru/stat/sources/phrases?id=11221648&oauth_token=' . $this->token . '&per_page=1000&filter=month&date1=' . $this->date1 . '&date2=' . $this->date2 . '&select_period=month';

        Query::model()->deleteAll();

        while (!empty($next)) {
            $val = $this->loadPage($next);
            $next = $this->getNextLink($val);

            //save to db
            foreach ($val['data'] as $query) {
//                if ($query['visits'] < $this->min_visits)
//                    break(2);
                $model = new Query();
                $model->attributes = $query;
                if ($model->save()) {
                    foreach ($query['search_engines'] as $search_engine) {
                        $se = new QuerySearchEngine();
                        $se->attributes = $search_engine;
                        $se->query_id = $model->id;
                        $se->session_id = 1;
                        $se->save();
                    }
                }
            }
        }

        //yandex
        $this->parseDataForSE(2);
        //google
        $this->parseDataForSE(3);
    }

    public function parseDataForSE($se_id)
    {
        $next = 'http://api-metrika.yandex.ru/stat/sources/phrases?id=11221648&oauth_token=' . $this->token . '&per_page=1000&filter=month&date1=' . $this->date1 . '&date2=' . $this->date2 . '&select_period=month&se_id=' . $se_id;
        while (!empty($next)) {
            $val = $this->loadPage($next);
            $next = $this->getNextLink($val);

            //save to db
            if (is_array($val['data']))
                foreach ($val['data'] as $query) {
                    $model = Query::model()->findByAttributes(array('phrase' => $query['phrase']));
                    if ($model !== null) {
                        $se = QuerySearchEngine::model()->findByAttributes(array(
                            'query_id' => $model->id,
                            'se_id' => $se_id,
                        ));
                        if ($se !== null) {
                            $se->visits = $query['visits'];
                            $se->save();
                        }
                    }
                }
            else
                break;
        }
    }

    public function getNextLink($val)
    {
        if (isset($val['links']['next']))
            $next = $val['links']['next'];
        else
            $next = null;

        return $next;
    }

    public function loadPage($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/x-yametrika+json'));
        curl_exec($ch);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}
