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

    /**
     * Возвращает даты, за которые нужно спарсить данные
     * @return array
     */
    public function getDatesForCheck()
    {
        $dates = array();
        $last_date = Yii::app()->db_seo->createCommand()->select('max(date)')->from('queries')->queryScalar();
        if (empty($last_date))
            $last_date = date("Ymd", strtotime('-100 days'));
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

    public function parseQueries($date)
    {
        if (empty($date)) {
            $dates = $this->getDatesForCheck();
            foreach ($dates as $date) {
                echo $date . "\n";
                $this->parseDate($date);
            }
        } else
            $this->parseDate($date);
    }

    public function parseDate($date)
    {
        $count = 0;
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
                $count++;
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

        echo "$count\n";

//        foreach ($this->se as $se)
//            $this->parseDataForSE($se, $date);
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


    function cmp($a, $b)
    {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? 1 : -1;
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

    /**
     * Возявращает результат сравнения трафика по ключевым словам
     * @param $date1
     * @param $date2
     * @return array
     */
    public function compareDates($date1, $date2)
    {
        $keywords = array();

        $dataProvider = new CActiveDataProvider('Query', array(
            'criteria' => array(
                'condition' => 'date="' . $date1 . '"',
            ),
        ));
        $iterator = new CDataProviderIterator($dataProvider, 100);
        foreach ($iterator as $query) {
            $keywords[$query->keyword_id] = array(0 => $query->visits, 1 => 0);
            $keywords[$query->keyword_id][3] = $this->getPhraseUrl($query->keyword_id);
        }

        $dataProvider = new CActiveDataProvider('Query', array(
            'criteria' => array(
                'condition' => 'date="' . $date2 . '"',
            ),
        ));
        $iterator = new CDataProviderIterator($dataProvider, 100);
        foreach ($iterator as $query) {
            if (isset($keywords[$query->keyword_id]))
                $keywords[$query->keyword_id][1] = $query->visits;
            else
                $keywords[$query->keyword_id] = array(1 => $query->visits, 0 => 0);

            $keywords[$query->keyword_id][3] = $this->getPhraseUrl($query->keyword_id);
        }

        foreach ($keywords as $key => $keyword)
            $keywords[$key][2] = $keyword[0] + $keyword[1];

        uasort($keywords, array($this, "cmp2"));

        return $keywords;
    }

    private function getPhraseUrl($keyword_id)
    {
        $phrases = Yii::app()->db_seo->createCommand()
            ->select('id')
            ->from('pages_search_phrases')
            ->where('keyword_id=' . $keyword_id)
            ->queryColumn();

        if (!empty($phrases)) {
            $best_phrase = Yii::app()->db_seo->createCommand()
                ->select('search_phrase_id')
                ->from('pages_search_phrases_positions')
                ->where('search_phrase_id IN (' . implode(',', $phrases) . ')')
                ->order('date desc')
                ->limit(1)
                ->queryScalar();
            if (!empty($best_phrase)) {
                $phrase = PagesSearchPhrase::model()->findByPk($best_phrase);
                return $phrase->page->url;
            }
        }

        return '';
    }

    function cmp2($a, $b)
    {
        if ($a[2] == $b[2]) {
            return 0;
        }
        return ($a[2] < $b[2]) ? 1 : -1;
    }
}
