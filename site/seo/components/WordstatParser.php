<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatParser extends ProxyParserThread
{
    const PARSE_LIMIT = 100;

    /**
     * @var ParsingKeyword[]
     */
    public $keywords = array();
    /**
     * @var ParsingKeyword
     */
    public $keyword = null;
    public $next_page = '';
    public $first_page = true;
    private $fails = 0;

    public function init($mode)
    {
        $this->debug = $mode;
        $this->removeCookieOnChangeProxy = false;

        $this->getCookie();
    }

    public function start($mode)
    {
        $this->init($mode);

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
            $this->getKeyword();
            while (!isset($this->keyword->keyword)) {
                $this->keyword->delete();
                $this->getKeyword();
            }
            $this->next_page = 'http://wordstat.yandex.ru/?cmd=words&page=1&t=' . urlencode($this->keyword->keyword->name) . '&geo=&text_geo=';
        }
    }

    public function loadKeywords()
    {
        $this->startTimer('load keywords');
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);
        $criteria->order = 'priority desc';
        $criteria->limit = 10;
        $criteria->offset = rand(0, 1000);
        $this->keywords = ParsingKeyword::model()->findAll($criteria);

        //update active
        $keys = array();
        foreach ($this->keywords as $key)
            $keys [] = $key->keyword_id;

        Yii::app()->db_seo->createCommand()->update('parsing_keywords', array('active' => 1),
            'keyword_id IN (' . implode(',', $keys) . ')');
        $this->endTimer();
        $this->log(count($this->keywords) . ' keywords loaded');
    }

    public function getKeyword()
    {
        $this->first_page = true;

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
            if ($this->first_page)
                YandexPopularity::model()->addValue($this->keyword->keyword_id, $matches[1], $this->keyword->theme);
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

        if (empty($this->next_page))
            $this->RemoveCurrentKeywordFromParsing();
        else {
            $this->first_page = false;
//            $this->log('next page: ' . $this->next_page);
        }

        $document->unloadDocument();

        return true;
    }

    public function addData($keyword, $value, $related = false)
    {
        if (!empty($keyword) && !empty($value)) {
            if (strpos($keyword, '+') !== false) {
                $keyword = str_replace(' +', ' ', $keyword);
                $keyword = ltrim($keyword, '+');
            }

            $model = Keyword::GetKeyword($keyword);

            if ($related)
                KeywordRelation::saveRelation($this->keyword->keyword_id, $model->id);

            if ($model !== null) {
                if ($value >= self::PARSE_LIMIT)
                    $this->AddKeywordToParsing($model->id, $this->keyword->theme);
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
        if ($keyword_id == $this->keyword->keyword_id)
            return;

        $this->startTimer('add_keyword_to_parsing');

        $yandex = YandexPopularity::model()->findByPk($keyword_id);
        //если уже спарсили полностью и была задана тематика
        if ($yandex !== null && $yandex->parsed == 1) // && (!empty($yandex->theme) && !empty($theme) || empty($theme)))
            return;

        $exist = ParsingKeyword::model()->findByPk($keyword_id);
        if ($exist === null) {
            $parsing_model = new ParsingKeyword();
            $parsing_model->keyword_id = $keyword_id;
            $parsing_model->priority = $this->keyword->priority;
            $parsing_model->theme = $theme;
            try {
                $parsing_model->save();
            } catch (Exception $err) {
            }
        } else {
            $exist->priority = $this->keyword->priority;
            $exist->theme = $theme;
            $exist->save();
        }

        $this->endTimer();
    }

    /**
     * Когда спарсили все - удаляем кейворд из очереди на парсинг
     */
    public function RemoveCurrentKeywordFromParsing()
    {
        $this->startTimer('remove_from_parsing');
        //добавляем в спарсенные
        $yandex = YandexPopularity::model()->findByPk($this->keyword->keyword_id);
        if ($yandex !== null) {
            $yandex->parsed = 1;
            if (!$yandex->save())
                echo 'not saved!';
        }

        //удаляем кейворд из парсинга
        ParsingKeyword::model()->deleteByPk($this->keyword->keyword_id);
        $this->endTimer();
    }

    /**
     * @param Keyword $model
     * @param int $value
     */
    public function AddStat($model, $value)
    {
        YandexPopularity::model()->addValue($model->id, $value, $this->keyword->theme);
    }

    public function getSimpleValue($keyword)
    {
        $url = 'http://wordstat.yandex.ru/?cmd=words&t=' . urlencode($keyword) . '&geo=&text_geo=';
        $html = $this->query($url, 'http://wordstat.yandex.ru/');

        $html = str_replace('&nbsp;', ' ', $html);
        $html = str_replace('&mdash;', '—', $html);

        //find and add our keyword
        if (preg_match('/— ([\d]+) показ[ов]*[а]* в месяц/', $html, $matches)) {
            return $matches[1];
        } else return -1;
    }

    public function closeThread($reason = 'unknown reason')
    {
        if (!empty($this->keyword))
            $this->keywords [] = $this->keyword;

        foreach ($this->keywords as $keyword) {
            $keyword->active = 0;
            $keyword->save();
        }

        parent::closeThread($reason);
    }
}
