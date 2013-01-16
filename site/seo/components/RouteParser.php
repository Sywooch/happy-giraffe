<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class RouteParser extends ProxyParserThread
{
    const PARSE_LIMIT = 100;

    /**
     * @var Route
     */
    public $route = null;
    public $next_page = '';
    public $first_page = true;
    private $fails = 0;

    private $keyword;

    public function start($mode)
    {
        $this->delay_min = 1;
        $this->delay_max = 3;
        $this->timeout = 45;
        $this->debug = $mode;
        $this->removeCookieOnChangeProxy = false;

        $this->getCookie();

        while (true) {
            $this->getNextPage();

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

                sleep(1);
            }
        }
    }

    public function getNextPage()
    {
        if (empty($this->next_page)) {
            $this->getRoute();
            $this->next_page = 'http://wordstat.yandex.ru/?cmd=words&page=1&t=' . urlencode($this->getKeyword()) . '&geo=&text_geo=';
        }
    }

    public function getKeyword()
    {
        return 'расстояние ' . $this->route->cityFrom->name . ' ' . $this->route->cityTo->name;
    }

    public function getRoute()
    {
        $this->first_page = true;

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $this->route = Route::model()->find('active=0');
            $this->route->active = 1;
            $this->route->save();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();

            sleep(10);
            $this->getRoute();
        }
    }

    private function getCookie()
    {
        $url = 'http://wordstat.yandex.ru/';
        $success = false;

        $this->log('starting get cookie');

        while (!$success) {
            $this->query($url);
            $success = true;
            $html = $this->query('http://kiks.yandex.ru/su/', $url);
            if (strpos($html, 'Set-Cookie:') === false) {
                $success = false;
            }

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
        $html = $this->query($this->next_page, 'http://wordstat.yandex.ru/');
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
        if (preg_match('/— ([\d]+) показ[ов]*[а]* в месяц/', $html, $matches)) {
            $this->log('valid page loaded');

            if ($this->first_page) {
                if ($matches[1] > 0) {
                    $this->keyword = Keyword::GetKeyword($this->getKeyword());
                    YandexPopularity::model()->addValue($this->keyword->id, $matches[1], 0);
                } else
                    $this->keyword = null;

                $this->route->wordstat = $matches[1];
                $this->route->save();
            }
        } else return false;


        //find keywords in block "Что искали со словом"
        foreach ($document->find('table.campaign tr td table:first td a') as $link) {
            $keyword = trim(pq($link)->text());
            $value = (int)pq($link)->parent()->next()->next()->text();

            $this->addData($keyword, $value);
        }

        //собирает кейворды из блока "Что еще искали люди, искавшие"
        //так как на остальных кейворды повторяются
        if ($this->first_page)
            foreach ($document->find('table.campaign tr td table:eq(1) td a') as $link) {
                $keyword = trim(pq($link)->text());
                $value = (int)pq($link)->parent()->next()->next()->text();

                $this->addData($keyword, $value, true);
            }

        //ищем ссылку на следующую страницу
        $this->next_page = '';
        foreach ($document->find('div.pages a') as $link) {
            $title = pq($link)->text();
            if (strpos($title, 'следующая') !== false)
                $this->next_page = 'http://wordstat.yandex.ru/' . pq($link)->attr('href');
        }

        if (empty($this->next_page)) {
            $this->route->active = 2;
            $this->route->save();

            if ($this->keyword !== null) {
                $this->keyword->yandex->parsed = 1;
                $this->keyword->yandex->save();
            }

        } else
            $this->first_page = false;

        $document->unloadDocument();

        return true;
    }

    public function addData($keyword, $value, $related = false)
    {
        if (!empty($keyword) && !empty($value)) {
            if (strpos($keyword, '+') !== false){
                $keyword = str_replace(' +', ' ', $keyword);
                $keyword = ltrim($keyword,'+');
            }

            $model = Keyword::GetKeyword($keyword);

            if ($model !== null) {
                if ($value >= self::PARSE_LIMIT)
                    $this->AddKeywordToParsing($model->id, 0);
                $this->AddStat($model, $value);
            }
        }
    }

    /**
     * @param int $keyword_id
     * @param $theme
     * @return void
     */
    public function AddKeywordToParsing($keyword_id, $theme)
    {
        $this->startTimer('add_keyword_to_parsing');

        $yandex = YandexPopularity::model()->findByPk($keyword_id);
        //если уже спарсили полностью и была задана тематика
        if ($yandex === null || $yandex->parsed == 0) {
            $exist = ParsingKeyword::model()->findByPk($keyword_id);
            if ($exist === null) {
                $parsing_model = new ParsingKeyword();
                $parsing_model->keyword_id = $keyword_id;
                $parsing_model->priority = 1;
                $parsing_model->theme = $theme;
                try {
                    $parsing_model->save();
                } catch (Exception $err) {
                }
            }
        }

        $this->endTimer();
    }

    /**
     * @param Keyword $model
     * @param int $value
     */
    public function AddStat($model, $value)
    {
        YandexPopularity::model()->addValue($model->id, $value, 0);
    }

    public function closeThread($reason = 'unknown reason')
    {
        $this->route->active = 0;
        parent::closeThread($reason);
    }
}
