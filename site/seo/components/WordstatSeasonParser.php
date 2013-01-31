<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatSeasonParser extends ProxyParserThread
{
    /**
     * @var YandexPopularity[]
     */
    public $keywords = array();
    /**
     * @var YandexPopularity
     */
    public $keyword = null;
    private $fails = 0;

    public function init($mode)
    {
        $this->debug = $mode;
        $this->use_proxy = false;
        $this->removeCookieOnChangeProxy = false;

        $this->getCookie();
    }

    public function start($mode)
    {
        $this->init($mode);

        while (true) {
            $this->getKeyword();

            $success = false;
            while (!$success) {
                $success = $this->parseQuery();

                if (!$success) {
                    $this->fails++;
                    if ($this->fails > 10) {
                        $this->removeCookieFile();
                        $this->getCookie();
                        $this->fails = 0;
                    } else
                        $this->changeBadProxy();
                } else {
                    $this->success_loads++;
                    $this->fails = 0;
                }
            }

            sleep(1);
        }
    }

    public function loadKeywords()
    {
        $this->startTimer('load keywords');

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $criteria = new CDbCriteria;
            $criteria->compare('season_parsed', 0);
            $criteria->limit = 10;
            $this->keywords = YandexPopularity::model()->findAll($criteria);

            $keys = array();
            foreach ($this->keywords as $key)
                $keys [] = $key->keyword_id;

            Yii::app()->db_seo->createCommand()->update('yandex_popularity', array('season_parsed' => 1),
                'keyword_id IN (' . implode(',', $keys) . ')');
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            $this->log('transaction failed');
            Yii::app()->end();
        }

        $this->endTimer();
        $this->log(count($this->keywords) . ' keywords loaded');
    }

    public function getKeyword()
    {
        if (empty($this->keywords))
            $this->loadKeywords();

        $this->keyword = array_pop($this->keywords);
    }

    private function getCookie()
    {
        $url = 'http://wordstat.yandex.ru/';
        $success = false;

        $this->log('starting get cookie');

        while (!$success) {
            $data = $this->query($url);
            $success = true;
            if (preg_match('/<img src="\/\/mc.yandex.ru\/watch\/([\d]+)"/', $data, $res)) {
                $mc_url = 'http://mc.yandex.ru/watch/' . $res[1];
                $html = $this->query($mc_url, $url);
                if (strpos($html, 'Set-Cookie:') === false) {
                    $success = false;
//                    $this->log('mc.yandex.ru set cookie failed');
                }
            } else
                $success = false;
            $html = $this->query('http://kiks.yandex.ru/su/', $url);
            if (strpos($html, 'Set-Cookie:') === false) {
                $success = false;
//                $this->log('kiks.yandex.ru set cookie failed');
            }

            if (Config::getAttribute('stop_threads') == 1)
                $this->closeThread('manual exit');

            if (!$success) {
                $this->changeBadProxy();
                $this->removeCookieFile();
            }
            sleep(1);
        }

        $this->log('cookie received successfully');
    }

    private function parseQuery()
    {
        $html = $this->query('http://wordstat.yandex.ru/?cmd=months&page=1&t=' . urlencode($this->keyword->keyword->name), 'http://wordstat.yandex.ru/');

        if (!isset($html) || $html === null)
            return false;

        return $this->parseData($html);
    }

    public function parseData($html)
    {
        $this->log('parse page');

        $document = phpQuery::newDocument($html);
        $html = str_replace('&nbsp;', ' ', $html);
        $html = str_replace('&mdash;', '—', $html);

        //find and add our keyword
        if (strpos($html, 'Искомая комбинация слов нигде не встречается')) {
            $this->log('valid page loaded');
            $this->successKeyword(0);
        } else {

            if (preg_match('/Показов за последние 30 дней: ([\d]+)/', $html, $matches)) {
                $this->log('valid page loaded');
            } else {
                $document->unloadDocument();
                return false;
            }

            //парсим данные по месяцам
            $i = 0;
            $sum = 0;
            foreach ($document->find('table.reports.padding-5 td') as $cell) {
                if ($i % 3 == 0) {
                    $period = pq($cell)->text();
                    if (preg_match('/[\d]{2}.([\d]{2}).([\d]{4})/', $period, $matches)){
                        YandexPopularitySeason::addValue($this->keyword->keyword_id, $matches[1], $matches[2], pq($cell)->next()->text());
                        $sum += pq($cell)->next()->text();
                    }
                }

                $i++;
            }

            $this->successKeyword(round($sum/24));
        }

        $document->unloadDocument();
        return true;
    }

    public function successKeyword($value)
    {
        $this->keyword->season_parsed = 2;
        $this->keyword->season_value = $value;
        $this->keyword->save();
    }

    public function getMediumValue($keyword)
    {
        $html = $this->query('http://wordstat.yandex.ru/?cmd=months&page=1&t=' . urlencode($keyword), 'http://wordstat.yandex.ru/');
        $document = phpQuery::newDocument($html);
        $html = str_replace('&nbsp;', ' ', $html);
        $html = str_replace('&mdash;', '—', $html);

        if (strpos($html, 'Искомая комбинация слов нигде не встречается')) {
            return 0;
        } else {

            if (preg_match('/Показов за последние 30 дней: ([\d]+)/', $html, $matches)) {
                $this->log('valid page loaded');
            } else {
                $document->unloadDocument();
                return -1;
            }

            //парсим данные по месяцам
            $i = 0;
            $sum = 0;
            foreach ($document->find('table.reports.padding-5 td') as $cell) {
                if ($i % 3 == 0) {
                    $period = pq($cell)->text();
                    if (preg_match('/[\d]{2}.([\d]{2}).([\d]{4})/', $period, $matches)){
                        $sum += pq($cell)->next()->text();
                    }
                }

                $i++;
            }

            return round($sum/24);
        }
    }

    public function closeThread($reason = 'unknown reason')
    {
        if (!empty($this->keyword))
            $this->keywords [] = $this->keyword;

        foreach ($this->keywords as $keyword) {
            $keyword->season_parsed = 0;
            $keyword->save();
        }

        parent::closeThread($reason);
    }
}
