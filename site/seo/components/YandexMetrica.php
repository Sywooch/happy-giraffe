<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */
class YandexMetrica
{
    public $token = 'b1cb78403f76432b8a6803dc5e6631b5';
    private $counter_id = '11221648';
    const SE_GOOGLE = 3;
    const SE_YANDEX = 2;

    public $se = array(2, 3);

    public function getDatesForCheck()
    {
        $dates = array();
        $last_date = Yii::app()->db_seo->createCommand()->select('max(date)')->from('queries')->queryScalar();
        if (empty($last_date))
            $last_date = date("Ymd", strtotime('-42 days'));
        else
            $last_date = date("Ymd", strtotime($last_date));

        for ($i = 0; $i < 100; $i++) {
            $date = date("Ymd", strtotime('+1 day', strtotime($last_date)));
            if ($date != date("Ymd"))
                $dates [] = $date;
            else
                break;

            $last_date = $date;
        }

        return $dates;
    }

    public function parseQueries()
    {
        $dates = $this->getDatesForCheck();

        foreach ($dates as $date) {
            $next = 'http://api-metrika.yandex.ru/stat/sources/phrases?id=' . $this->counter_id . '&oauth_token=' . $this->token . '&per_page=1000&date1=' . $date . '&date2=' . $date;

            while (!empty($next)) {
                $val = $this->loadPage($next);
                $next = $this->getNextLink($val);

                if (!isset($val['data'])) {
                    var_dump($val);
                    Yii::app()->end();
                }

                //save to db
                foreach ($val['data'] as $query) {
                    $keyword = Keyword::GetKeyword($query['phrase']);

                    if ($keyword !== null) {
                        $model = Query::model()->findByAttributes(array(
                            'keyword_id' => $keyword->id,
                            'date' => $date,
                        ));
                        if ($model === null) {
                            $model = new Query();
                            $model->keyword_id = $keyword->id;
                            $model->date = $date;
                        }

                        $model->attributes = $query;
                        if ($model->save()) {
                            foreach ($query['search_engines'] as $search_engine) {
                                if (in_array($search_engine['se_id'], $this->se)) {
                                    $se = new QuerySearchEngine();
                                    $se->attributes = $search_engine;
                                    $se->query_id = $model->id;
                                    $se->save();
                                }
                            }
                        }
                    }
                }
            }

            foreach ($this->se as $se)
                $this->parseDataForSE($se, $date);

            SeoUserAttributes::setAttribute('traffic_parsed_date', $date, 1);
            //echo $date . " parsed\n";
        }
    }

    public function parseDataForSE($se_id, $date)
    {
        $next = 'http://api-metrika.yandex.ru/stat/sources/phrases?id=' . $this->counter_id . '&oauth_token=' . $this->token . '&per_page=1000&date1=' . $date . '&date2=' . $date . '&se_id=' . $se_id;
        while (!empty($next)) {
            $val = $this->loadPage($next);
            $next = $this->getNextLink($val);

            //save to db
            if (is_array($val['data']))
                foreach ($val['data'] as $query) {

                    $keyword = Keyword::GetKeyword($query['phrase']);
                    if ($keyword !== null) {
                        $model = Query::model()->findByAttributes(array(
                            'keyword_id' => $keyword->id,
                            'date' => $date,
                        ));
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
                }
            else
                break;
        }
    }

    public function getNextLink($val)
    {
        if (isset($val['links']['next']))
            $next = $val['links']['next'] . '&per_page=1000';
        else
            $next = null;

        return $next;
    }

    /**
     * Получить самые популярные статьи
     */
    public function Popular()
    {
        $date1 = date("Ymd", strtotime('-1 month'));
        $date2 = date("Ymd");
        $next = 'http://api-metrika.yandex.ru/stat/content/popular?date1=' . $date1 . '&date2=' . $date2
            . '&id=' . $this->counter_id . '&oauth_token=' . $this->token;

        $count = 0;
        $result = array();
        while (!empty($next)) {
            $val = $this->loadPage($next);
            $next = $this->getNextLink($val);

            if (is_array($val['data']))
                foreach ($val['data'] as $query) {
                    if (strpos($query['url'], 'http://happy-giraffe.ru/community/') === 0
                        && strpos($query['url'], '/forum/post/') !== FALSE
                        && strpos($query['url'], '#gallery-top') === FALSE
                        && strpos($query['url'], 'CommunityContent_page') === FALSE
                        && strpos($query['url'], '/photo') === FALSE
                    ) {
                        $result [] = array($query['url'], $query['entrance']);
                        //echo $query['url'] . ' - ' . $query['entrance'] . '<br>';
                        $count++;
                    }
                    if (strpos($query['url'], '/blog/post') !== FALSE) {
                        $result [] = array($query['url'], $query['entrance']);
                        //echo $query['url'] . ' - ' . $query['entrance'] . '<br>';
                        $count++;
                    }
                }
            else
                break;

            if ($count > 3000)
                break;
        }

        usort($result, array($this, "cmp"));

        $c = 0;
        foreach($result as $r){
            echo $r[0] . ' - ' . $r[1] . '<br>';
            $c++;
            if ($c > 2000)
                break;
        }
    }

    function cmp($a, $b)
    {
        return $b[1] - $a[1];
    }

    public function loadPage($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/x-yametrika+json'));
        curl_exec($ch);
        $result = curl_exec($ch);
        curl_close($ch);
        sleep(2);
        return json_decode($result, true);
    }
}
