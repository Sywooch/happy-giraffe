<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatParser extends ProxyParserThread
{
    public $cookie;
    /**
     * @var ParsingKeywords
     */
    public $keyword = null;

    public function start()
    {
        $this->delay_min = 0;
        $this->delay_max = 0;
        $this->timeout = 10;
        $this->debug = false;

        $this->getCookie();

        while (true) {
            $this->getKeyword();
            $success = false;

            while (!$success) {
                $success = $this->parseQuery();
                if (!$success)
                    $this->changeBadProxy();
            }
            sleep(10);

            if (Config::getAttribute('stop_threads') == 1)
                break;
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
        $this->getCookie();
    }

    private function getCookie()
    {
        $url = 'http://wordstat.yandex.ru/';
        $mc_url = '';

        while (empty($mc_url)) {
            $data = $this->query($url);

            if (preg_match('/<img src="\/\/mc.yandex.ru\/watch\/([\d]+)"/', $data, $res)) {
                $mc_url = 'http://mc.yandex.ru/watch/' . $res[1];
                $this->query($mc_url, $url);
            }
            $this->query('http://kiks.yandex.ru/su/', $url);
        }
    }

    private function parseQuery()
    {
        $html = $this->query('http://wordstat.yandex.ru/?cmd=words&page=1&t=' . urlencode($this->keyword->keyword->name) . '&geo=&text_geo=', 'http://wordstat.yandex.ru/');

        $document = phpQuery::newDocument($html);
        $k = 0;
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

        if (!empty($keyword) && !empty($value)) {
            $model = Keywords::model()->findByAttributes(array('name' => $old_keyword));
            if ($model !== null) {
                $yaPop = YandexPopularity::model()->findByPk($model->id);
                if ($yaPop !== null){
                    $yaPop->value = $value;
                    $yaPop->save();
                }else{
                    $yaPop = new YandexPopularity;
                    $yaPop->keyword_id = $model->id;
                    $yaPop->value = $value;
                    $yaPop->save();
                }
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
                $yaPop->save();
            } else {
                $yaPop = YandexPopularity::model()->findByPk($model->id);
                if ($yaPop !== null){
                    $yaPop->value = $value;
                    $yaPop->save();
                }else{
                    $yaPop = new YandexPopularity;
                    $yaPop->keyword_id = $model->id;
                    $yaPop->value = $value;
                    $yaPop->save();
                }
                ParsingKeywords::model()->deleteByPk($model->id);
            }
        }
    }
}
