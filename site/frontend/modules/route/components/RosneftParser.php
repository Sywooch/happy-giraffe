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
        Yii::import('site.seo.models.*');
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');

        $this->getProxy();

        while ($this->route !== null) {
            $this->getRoute();
            $result = $this->parseRoute();
            if (!$result) {
                $this->route->status = Route::STATUS_ROSNEFT_NOT_FOUND;
                $this->route->save();
            }
        }
    }

    private function getProxy()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('status', 0);
        $criteria->order = 'rank desc';
        $criteria->offset = rand(0, 10);

        $this->proxy = Proxy::model()->find($criteria);
        $this->proxy->status = 1;
        $this->proxy->save();
    }

    public function getRoute()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('status', 0);
        $criteria->order = 'rand()';

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $this->route = Route::model()->find($criteria);
            $this->route->status = 1;
            $this->route->save();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }
    }

    public function parseRoute()
    {
        $html = $this->loadPage();
        if (strpos($html, 'Сервис временно недоступен!')) {
            return false;
        }
        $document = phpQuery::newDocument($html);

        $i = 0;
        $distance = 0;
        $time = 0;
        $sum_distance = 0;

        RoutePoint::model()->deleteAll('route_id = :route_id', array(':route_id' => $this->route->id));

        foreach ($document->find('.timing_content .timing_city') as $city) {

            $region_city = trim(pq($city)->find('.region_city')->text());
            if (!empty($region_city)) {
                $region = $region_city;
                $region = $this->normalizeRegion($region);
            }

            $name = trim(pq($city)->find('.timing_city_item')->text());

            if ($i > 0)
                $this->saveStep($name, $region, $distance, $time);

            $distance = trim(pq($city)->find('.timing_city_distance2:first')->text());
            $distance = str_replace('км.', '', $distance);

            $sum_distance += $distance;

            $time = trim(pq($city)->find('.timing_city_distance2:last')->text());
            if (!empty($time)) {
                $times = explode(':', $time);
                $time = $times[0] * 60 + $times[1];
            }

            $i++;
        }

        $this->route->distance = $sum_distance;
        $this->route->update(array('distance'));

        $document->unloadDocument();

        return true;
    }


    public function saveStep($name, $region_name, $distance, $time)
    {
        if (!empty($name) && !empty($region_name) && !empty($distance)) {
            $p = new RoutePoint();
            $p->route_id = $this->route->id;
            $p->name = $name;

            if ($region_name == 'Чеченская Республика (Ичкерия)')
                $region_name = 'Чеченская Республика';
            $region = GeoRegion::model()->findByAttributes(array('name' => trim($region_name)));
            if ($region === null) {
                $this->saveRegionToFile($region_name);
                Yii::app()->end();
                return;
            }
            $p->region_id = $region->id;
            $city = GeoCity::model()->findByAttributes(array('region_id' => $region->id, 'name' => trim($name)));
            if ($city !== null)
                $p->city_id = $city->id;
            $p->distance = $distance;
            $p->time = $time;
            $p->save();

            $this->route->status = Route::STATUS_ROSNEFT_FOUND;
            $this->route->save();
        }
    }

    public function loadPage()
    {
        $url = 'http://www.global.rn-card.ru/services/route/';
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:18.0) Gecko/20100101 Firefox/18.0');

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getPostData());

            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy->value);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexhg:Nokia1111");
            curl_setopt($ch, CURLOPT_PROXYAUTH, 1);

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
                if (strpos($content, 'Роснефть') === false) {
                    $this->changeBadProxy();
                    return $this->loadPage();
                }
                return $content;
            }
        }

        return false;
    }

    protected function changeBadProxy()
    {
        $this->proxy->rank = $this->proxy->rank - 2;
        $this->proxy->status = 0;
        $this->proxy->save();
        $this->getProxy();
    }

    public function getPostData()
    {
        $start = $this->route->cityFrom->name . ', ' . $this->route->cityFrom->region->name . ', ' . $this->route->cityFrom->country->name;
        $end = $this->route->cityTo->name . ', ' . $this->route->cityTo->region->name . ', ' . $this->route->cityTo->country->name;

        return 'start=' . urlencode($start) . '&end=' . urlencode($end) . '&city%5B%5D=&city%5B%5D=&city%5B%5D=&speed%5B6%5D=30&speed%5B5%5D=80&speed%5B3%5D=60&speed%5B1%5D=40&speed%5B10%5D=20&speed%5B4%5D=70&speed%5B2%5D=50&speed%5B0%5D=40&delay%5B1%5D=5&delay%5B3%5D=15&delay%5B5%5D=60&delay%5B11%5D=60&delay%5B2%5D=10&delay%5B4%5D=15&delay%5B6%5D=60&delay%5B12%5D=60&bestTime=1&onmap=on&x=109&y=' . rand(35, 42);
    }

    public function saveRegionToFile($name)
    {
        $fh = fopen($dir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'regions.txt', 'a');
        fwrite($fh, $name . "\n");
    }

    public function normalizeRegion($region)
    {
        $region = str_replace(' (регион)', '', $region);

        if ($region == 'Чеченская Республика (Ичкерия)') return 'Чеченская Республика';
        if ($region == 'Еврейская авт. область') return 'Еврейская автономная область';
        if ($region == 'Волгоград') return 'Волгоградская область';
        if ($region == 'Усть-Ордынский Бурятский авт.') return 'Иркутская область';
        if ($region == 'Респ. Северная Осетия (Алания)') return 'Республика Северная Осетия-Алания';
        if ($region == 'Республика Кабардино-Балкария') return 'Кабардино-Балкарская Республика';
        if ($region == 'Западно Казахстанская область') return 'Западно-Казахстанская область';
        if ($region == 'Кызыл-Ординская область') return 'Кзыл-Ординская область';
        if ($region == 'Карачаево-Черкесская Республик') return 'Карачаево-Черкесская Республика';
        if ($region == 'Ханты-Манс. авт. окр.') return 'Ханты-Мансийский Автономный округ';

        return $region;
    }
}
