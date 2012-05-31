<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */
class YandexMetrica
{
    public $token = 'b1cb78403f76432b8a6803dc5e6631b5';
    public $min_visits = 4;

    public function parseQueries()
    {
        $date1 = date("Ymd", strtotime('-1 month'));
        $date2 = date("Ymd");
        $next = 'http://api-metrika.yandex.ru/stat/sources/phrases?id=11221648&oauth_token=' . $this->token . '&per_page=1000&filter=month&date1=' . $date1 . '&date2=' . $date2 . '&select_period=month';

        Queries::model()->deleteAll();

        while (!empty($next)) {
            $ch = curl_init($next);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/x-yametrika+json'));
            curl_exec($ch);
            $result = curl_exec($ch);
            $val = json_decode($result, true);

            if (isset($val['links']['next']))
                $next = $val['links']['next'];
            else
                $next = null;

            //save to db
            foreach ($val['data'] as $query) {
                if ($query['visits'] < $this->min_visits)
                    break(2);
                $model = new Queries();
                $model->attributes = $query;
                if ($model->save()) {
                    foreach ($query['search_engines'] as $search_engine) {
                        $se = new QueriesSearchEngines();
                        $se->attributes = $search_engine;
                        $se->query_id = $model->id;
                        $se->save();
                    }
                }
            }
            curl_close($ch);
        }
    }

}
