<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatParser extends ProxyParserThread
{
    /**
     * @var ParsingKeyword
     */
    public $keyword = null;
    public $next_page = '';
    public $first_page = true;
    private $fails = 0;

    public function start($mode)
    {
        Config::setAttribute('stop_threads', 0);

        $this->delay_min = 2;
        $this->delay_max = 6;
        $this->timeout = 15;
        $this->debug = $mode;
        $this->removeCookieOnChangeProxy = false;

        $this->getCookie();

        while (true) {
            $this->getNextPage();

            $success = false;
            while (!$success) {
                $success = $this->parseQuery();

                if (!$success) {
                    $this->log('not valid page loaded');
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

                if (Config::getAttribute('stop_threads') == 1)
                    $this->closeThread('manual exit');

                sleep(1);
            }
        }
    }

    public function getNextPage()
    {
        if (empty($this->next_page)) {
            $this->getKeyword();
            $this->next_page = 'http://wordstat.yandex.ru/?cmd=words&page=1&t=' . urlencode($this->keyword->keyword->name) . '&geo=&text_geo=';
        }
    }

    public function getKeyword()
    {
        $this->keyword = null;

        $this->startTimer('getting keyword');
        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            //выбираем максимальный приоритет
//            $criteria = new CDbCriteria;
//            $criteria->order = 'priority desc';
//            $criteria->compare('active', 0);
//            $max_priority = ParsingKeyword::model()->find($criteria);

            //сначала выбираем с бесконечной глубиной парсинга
//            $criteria = new CDbCriteria;
//            $criteria->condition = 'depth IS NULL';
//            $criteria->compare('active', 0);
//            $criteria->compare('priority', $max_priority->priority);

            //затем все остальные упорядоченные по глубине парсинга
//            $criteria2 = new CDbCriteria;
//            $criteria2->compare('active', 0);
//            $criteria2->order = 'depth DESC';
//            $criteria2->compare('priority', $max_priority->priority);

            $criteria = new CDbCriteria;
            $criteria->condition = 'depth IS NULL';
            $criteria->compare('active', 0);
            $criteria->order = 'priority asc';
            $this->keyword = ParsingKeyword::model()->find($criteria);

            if ($this->keyword === null) {
                $criteria = new CDbCriteria;
                $criteria->compare('active', 0);
                $criteria->order = 'depth DESC';

                $this->keyword = ParsingKeyword::model()->find($criteria);
                if ($this->keyword === null)
                    $this->closeThread('Keywords for parsing ended');
            }

            $this->keyword->active = 1;
            $this->keyword->save();
            $transaction->commit();
            $this->endTimer();
        } catch (Exception $e) {
            $transaction->rollback();
            $this->closeThread('get keyword transaction failed');
        }

        $this->first_page = true;
        $this->endTimer();
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
                if (strpos($html, 'Set-Cookie:') === false)
                    $success = false;
            } else
                $success = false;
            $html = $this->query('http://kiks.yandex.ru/su/', $url);
            if (strpos($html, 'Set-Cookie:') === false)
                $success = false;

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
        $k = 0;
        if (preg_match('/— ([\d]+) показ[ов]*[а]* в месяц/', $html, $matches)) {
            YandexPopularity::model()->addValue($this->keyword->keyword_id, $matches[1]);
            $k = 1;
        }
        if ($k == 0)
            return false;

        $this->log('valid page loaded');

        //find keywords in block "Что искали со словом"
        foreach ($document->find('table.campaign tr td table:first td a') as $link) {
            $keyword = trim(pq($link)->text());
            $value = (int)pq($link)->parent()->next()->next()->text();
            if (!empty($keyword) && !empty($value)) {
                $keyword = preg_replace('/(\+)[\w]*/', '', $keyword);
                $model = Keyword::GetKeyword($keyword);
                if ($value >= 100)
                    $this->AddToParsingInclusiveKeyword($model);
                $this->AddStat($model, $value);
            }
        }

        //собирает кейворды из блока "Что еще искали люди, искавшие" - парсим только первую страницу
        //так как на остальных кейворды повторяются
        if ($this->first_page)
            foreach ($document->find('table.campaign tr td table:eq(1) td a') as $link) {
                $keyword = trim(pq($link)->text());
                $value = (int)pq($link)->parent()->next()->next()->text();
                if (!empty($keyword) && !empty($value)) {
                    $keyword = preg_replace('/(\+)[\w]*/', '', $keyword);
                    $model = Keyword::GetKeyword($keyword);
                    if ($value >= 100)
                        $this->AddToParsingAdjacentKeyword($model);
                    $this->AddStat($model, $value);
                }
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
            $this->log('next page: ' . $this->next_page);
        }

        $document->unloadDocument();

        return true;
    }

    public function AddToParsingInclusiveKeyword($model)
    {
        if (empty($this->keyword->depth)) {
            $this->AddKeywordToParsing($model->id);
        } elseif ($this->keyword->depth >= 2)
            $this->AddKeywordToParsing($model->id, 1);
    }

    public function AddToParsingAdjacentKeyword($model)
    {
        if (empty($this->keyword->depth)) {
            $this->AddKeywordToParsing($model->id, 2);
        }
    }

    /**
     * @param int $keyword_id
     * @param int $depth
     * @return
     * @internal param \Keyword $model
     */
    public function AddKeywordToParsing($keyword_id, $depth = null)
    {
        $this->startTimer('add keyword to parsing');
        if ($keyword_id == $this->keyword->keyword_id)
            return;

        $parsed = ParsedKeywords::model()->findByPk($keyword_id);
        if ($parsed !== null && (empty($parsed->depth) || $parsed->depth >= $depth))
            return;

        $exist = ParsingKeyword::model()->findByPk($keyword_id);
        if ($exist === null) {
            $parsing_model = new ParsingKeyword();
            $parsing_model->keyword_id = $keyword_id;
            $parsing_model->depth = $depth;
            try {
                $parsing_model->save();
            } catch (Exception $err) {
            }
        } else {
            if (empty($depth) && !empty($exist->depth))
                $exist->depth = null;
            elseif (!empty($exist->depth) && $exist->depth < $depth)
                $exist->depth = $depth;
            else
                return;

            try {
                $exist->save();
            } catch (Exception $e) {
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
        YandexPopularity::model()->addValue($model->id, $value);
        $model->our = 1;
        $model->save();
    }

    public function closeThread($reason = 'unknown reason')
    {
        if ($this->keyword !== null) {
            $this->keyword->active = 0;
            $this->keyword->save();
        }

        parent::closeThread($reason);
    }

    /**
     * Когда спарсили все - удаляем кейворд из очереди на парсинг
     */
    public function RemoveCurrentKeywordFromParsing()
    {
        $this->startTimer('Remove Current Keyword From Parsing');

        //проверяем не изменилась ли глубина за время парсинга
        $old_depth = $this->keyword->depth;
        $this->keyword->refresh();
        if ($this->keyword->depth > $old_depth) {
            //если глубина увеличилась, переходим к следующему слову
            $this->keyword->active = 0;
            $this->keyword->save();
        } else {
            //иначе удаляем кейворд из парсинга
            $this->log($this->keyword->keyword_id . " - remove keyword from parsing");

            ParsingKeyword::model()->deleteByPk($this->keyword->keyword_id);

            $success = false;
            while (!$success) {
                //и добавляем в спарсенные
                $parsed = ParsedKeywords::model()->findByPk($this->keyword->keyword_id);
                if ($parsed !== null) {
                    if (($parsed->depth < $this->keyword->depth) ||
                        (empty($this->keyword->depth) && !empty($parsed->depth))
                    ) {
                        $parsed->depth = $this->keyword->depth;
                        try {
                            $success = $parsed->save();
                        } catch (Exception $err) {
                            $success = false;
                        }
                    } else
                        $success = true;
                } else {
                    $parsed = new ParsedKeywords;
                    $parsed->keyword_id = $this->keyword->keyword_id;
                    $parsed->depth = $this->keyword->depth;
                    try {
                        $success = $parsed->save();
                    } catch (Exception $err) {
                        $success = false;
                    }
                }
                if (!$success)
                    sleep(1);
            }
        }

        $this->endTimer();
    }
}
