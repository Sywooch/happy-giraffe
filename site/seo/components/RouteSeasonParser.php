<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 */
class RouteSeasonParser extends ProxyParserThread
{
    /**
     * @var RouteParsing
     */
    public $route = null;
    private $fails = 0;

    public function init($mode)
    {
        $this->debug = $mode;
        $this->removeCookieOnChangeProxy = true;

        $this->getCookie();
    }

    public function start($mode)
    {
        $this->init($mode);

        while (true) {
            $this->getRoute();

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

    public function getKeyword()
    {
        return 'расстояние ' . $this->route->cityFrom->name . ' ' . $this->route->cityTo->name;
    }

    public function getRoute()
    {
        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->route = RouteParsing::model()->find('active=0');
            $this->route->active = 1;
            $this->route->save();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();

            sleep(10);
            $this->getRoute();
        }
        $this->log('new route loaded - ' . $this->route->id);
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
                }
            } else
                $success = false;
            $html = $this->query('http://kiks.yandex.ru/su/', $url);
            if (strpos($html, 'Set-Cookie:') === false) {
                $success = false;
            }

            if (!$success) {
                $this->log('cookie not received');
                $this->changeBadProxy();
                $this->removeCookieFile();
            }
        }

        $this->log('cookie received successfully');
    }

    private function parseQuery()
    {
        sleep(2);
        $html = $this->query('http://wordstat.yandex.ru/?cmd=months&t=' . urlencode($this->getKeyword()), 'http://wordstat.yandex.ru/');

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
                    if (preg_match('/[\d]{2}.([\d]{2}).([\d]{4})/', $period, $matches)) {
                        $month = (int)$matches[1];
                        if ($matches[2] == 2012 && in_array($month, array(5, 6, 7, 8, 9)))
                            $sum += pq($cell)->next()->text();
                    }
                }

                $i++;
            }

            $this->successKeyword(round($sum / 5));
        }

        $document->unloadDocument();
        return true;
    }


    public function successKeyword($value)
    {
        if ($this->route->wordstat < $value)
            $this->route->wordstat = $value;

        $this->route->active = 2;
        $this->route->save();
    }
}
