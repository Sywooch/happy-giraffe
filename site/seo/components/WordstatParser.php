<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatParser extends ProxyParserThread
{
    /**
     * @var ParsingKeywords
     */
    public $keyword = null;

    public function start($mode)
    {

        Config::setAttribute('stop_threads', 0);

        $this->delay_min = 0;
        $this->delay_max = 0;
        $this->timeout = 15;
        $this->debug = $mode;
        $this->removeCookieOnChangeProxy = false;

        $this->getCookie();

        while (true) {
            $this->getKeyword();
            $success = false;

            while (!$success) {
                $success = $this->parseQuery();
                if (!$success)
                    $this->changeBadProxy();
                else
                    $this->success_loads++;

                if (Config::getAttribute('stop_threads') == 1)
                    $this->closeThread('manual exit');
            }
            sleep(rand(10, 15));
        }
    }

    public function getKeyword()
    {
        if ($this->keyword !== null)
            ParsingKeywords::model()->deleteByPk($this->keyword->keyword_id);

        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->keyword = ParsingKeywords::model()->find($criteria);
            if ($this->keyword === null) {
                $this->closeThread('there are no keywords');
            }

            $this->keyword->active = 1;
            $this->keyword->save();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            $this->closeThread('Fail with getting keyword');
        }
    }

    public function afterProxyChange()
    {
        //$this->getCookie();
    }

    private function getCookie()
    {
        $url = 'http://wordstat.yandex.ru/';
        $success = false;

        while (!$success) {
            $data = $this->query($url);
            $success = true;
            if (preg_match('/<img src="\/\/mc.yandex.ru\/watch\/([\d]+)"/', $data, $res)) {
                $mc_url = 'http://mc.yandex.ru/watch/' . $res[1];
                $html = $this->query($mc_url, $url);
                if (strpos($html, 'Set-Cookie:') === false)
                    $success = false;
            } else
                $success = false;
            $html = $this->query('http://kiks.yandex.ru/su/', $url);
            if (strpos($html, 'Set-Cookie:') === false)
                $success = false;

            if (Config::getAttribute('stop_threads') == 1)
                $this->closeThread('manual exit');

            if (!$success)
                $this->changeBadProxy();
        }
    }

    private function parseQuery()
    {
        $html = $this->query('http://wordstat.yandex.ru/?cmd=words&page=1&t=' . urlencode($this->keyword->keyword->name) . '&geo=&text_geo=', 'http://wordstat.yandex.ru/');
        if (!isset($html) || $html === null)
            return false;

        return $this->parseData($html);
    }

    public function parseData($html)
    {
        $document = phpQuery::newDocument($html);
        $html = str_replace('&nbsp;', ' ', $html);
        $html = str_replace('&mdash;', '—', $html);

        $k = 0;
        if (preg_match('/— ([\d]+) показ[ов]*[а]* в месяц/', $html, $matches)) {
            YandexPopularity::addValue($this->keyword->keyword_id, $matches[1]);
            ParsingKeywords::model()->deleteByPk($this->keyword->keyword_id);
            $k = 1;
        }

        foreach ($document->find('table.campaign tr td table td a') as $link) {
            $keywords = pq($link)->text();
            $value = (int)pq($link)->parent()->next()->next()->text();
            $this->AddStat($keywords, $value);
            $k++;
        }
        if ($k == 0)
            return false;

        return true;
    }

    public function AddStat($keyword, $value)
    {
        $old_keyword = trim($keyword);
        $keyword = str_replace('+', '', $old_keyword);
        if ($this->debug)
            echo $keyword . ' - ' . $value . "\n";

        if (!empty($keyword) && !empty($value)) {
            $model = Keywords::model()->findByAttributes(array('name' => $old_keyword));
            if ($model !== null) {
                YandexPopularity::addValue($model->id, $value);
                ParsingKeywords::model()->deleteByPk($model->id);
            }

            $model = Keywords::model()->findByAttributes(array('name' => $keyword));
            if ($model === null) {
                $model = new Keywords();
                $model->name = $keyword;
                $model->save();

                $yaPop = new YandexPopularity;
                $yaPop->keyword_id = $model->id;
                $yaPop->value = $value;
                try {
                    $yaPop->save();
                } catch (Exception $e) {

                }
            } else {
                YandexPopularity::addValue($model->id, $value);
                ParsingKeywords::model()->deleteByPk($model->id);
            }
        }
    }

    public function closeThread($reason = 'unknown reason')
    {
        $this->keyword->active = 0;
        $this->keyword->save();

        parent::closeThread($reason);
    }
}
