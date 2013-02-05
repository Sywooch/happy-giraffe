<?php
/**
 * Author: alexk984
 * Date: 05.02.13
 */
class RosneftParser
{
    /**
     * @var Route
     */
    public $route = 1;
    public $proxy;

    public function start()
    {
        $this->getProxy();

        while ($this->route !== null){
            $this->getRoute();
            $this->parseRoute();
        }
    }

    private function getProxy()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);
        $criteria->order = 'rank desc';
        $criteria->offset = rand(0, 10);

        $this->proxy = Proxy::model()->find($criteria);
        $this->proxy->active = 1;
        $this->proxy->save();
    }

    public function getRoute()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $this->route = Route::model()->find($criteria);
            $this->route->active = 1;
            $this->route->save();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }
    }

    public function parseRoute()
    {
        $html = $this->loadPage();
        $document = phpQuery::newDocument($html);

        $i = 0;
        foreach ($document->find('.timing_content .timing_city') as $city) {
            $i++;
            $region_city = trim(pq($city)->find('.region_city')->text());
            if (!empty($region_city)){
                $region = $region_city;
                $region = str_replace(' (регион)', '', $region);
            }

            $distance = trim(pq($city)->find('.timing_city_distance2:first')->text());
            $distance = str_replace('км.', '', $distance);

            if ($i == 1)
                continue;

            $name = trim(pq($city)->find('.timing_city_item')->text());

        }
    }

    public function loadPage()
    {
        $url = 'http://www.global.rn-card.ru/services/route/';
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:18.0) Gecko/20100101 Firefox/18.0');

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getPostData());

//            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
//            curl_setopt($ch, CURLOPT_PROXY, $this->proxy->value);
//            if (Yii::app()->params['use_proxy_auth']) {
//                curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexhg:Nokia1111");
//                curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
//            }

            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $content = curl_exec($ch);
            curl_close($ch);

            if ($content === false) {
                $this->changeBadProxy();
                return $this->loadPage();
            } else {
                return $content;
            }
        }

        return false;
    }

    protected function changeBadProxy()
    {
        $this->proxy->rank = $this->proxy->rank - 2;
        $this->proxy->active = 0;
        $this->proxy->save();
        $this->getProxy();
    }

    public function getPostData()
    {
        $start = $this->route->cityFrom->name.', '.$this->route->cityFrom->region->name.', '.$this->route->cityFrom->country->name;
        $end = $this->route->cityTo->name.', '.$this->route->cityTo->region->name.', '.$this->route->cityTo->country->name;

        return 'start='.urlencode($start).'&end='.urlencode($end).'&city%5B%5D=&city%5B%5D=&city%5B%5D=&speed%5B6%5D=30&speed%5B5%5D=80&speed%5B3%5D=60&speed%5B1%5D=40&speed%5B10%5D=20&speed%5B4%5D=70&speed%5B2%5D=50&speed%5B0%5D=40&delay%5B1%5D=5&delay%5B3%5D=15&delay%5B5%5D=60&delay%5B11%5D=60&delay%5B2%5D=10&delay%5B4%5D=15&delay%5B6%5D=60&delay%5B12%5D=60&bestTime=1&onmap=on&x=109&y='.rand(35,42);
    }
}
