<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatParser extends ProxyParserThread
{
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
    /**
     * @var WordstatQueryModify
     */
    private $queryModify;

    public function init($mode)
    {
        $this->debug = $mode;
        $this->queryModify = new WordstatQueryModify;
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
            $t = urlencode($this->queryModify->prepareQuery($this->keyword->keyword->name));
            $this->next_page = 'http://wordstat.yandex.ru/?cmd=words&page=1&t=' . $t . '&geo=&text_geo=';
        }
    }

    public function loadKeywords()
    {
        $this->startTimer('load keywords');

        //сначала загружаем приоритетные фразы
        Yii::app()->db_keywords->createCommand("
                update parsing_keywords
                set active=:pid
                where active=0 AND type=0 AND priority > 0
                limit 20
        ")->execute(array(':pid' => $this->thread_id));

        $criteria = new CDbCriteria;
        $criteria->compare('active', $this->thread_id);
        $this->keywords = ParsingKeyword::model()->findAll($criteria);

        if (empty($this->keywords)) {
            //если нет приоритетных загружаем остальные
            $criteria = new CDbCriteria;
            $criteria->compare('active', 0);
            $criteria->compare('type', 0);
            $criteria->limit = 20;
            $criteria->offset = rand(0, 1000);
            $criteria->order = 'updated asc';

            $this->keywords = ParsingKeyword::model()->findAll($criteria);
            $this->log(count($this->keywords) . ' keywords with 0 priority loaded');

            //update active
            $keys = array();
            foreach ($this->keywords as $key)
                $keys [] = $key->keyword_id;

            Yii::app()->db_keywords->createCommand()->update('parsing_keywords', array('active' => 1),
                'keyword_id IN (' . implode(',', $keys) . ')');
        } else
            $this->log(count($this->keywords) . ' priority keywords loaded');

        $this->endTimer();
    }

    public function getKeyword()
    {
        $this->first_page = true;

        if (empty($this->keywords))
            $this->loadKeywords();

        $this->keyword = array_shift($this->keywords);
        $this->log('Parsing keyword: ' . $this->keyword->keyword_id);
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
                $this->keyword->updateWordstat($matches[1]);
            $this->log('wordstat value: ' . $matches[1]);
        } else return false;

        //find keywords in block "Что искали со словом"
        foreach ($document->find('table.campaign tr td table:first td a') as $link) {
            $keyword = trim(pq($link)->text());
            $value = (int)pq($link)->parent()->next()->next()->text();

            $this->addData($keyword, $value);

            //временно ищем слова перед которыми надо ставить +
            $this->queryModify->analyzeQuery($keyword);
        }

        //собирает кейворды из блока "Что еще искали люди, искавшие"
        //так как на остальных кейворды повторяются
        if ($this->first_page)
            foreach ($document->find('table.campaign tr td table:eq(1) td a') as $link) {
                $keyword = trim(pq($link)->text());
                $value = (int)pq($link)->parent()->next()->next()->text();

                $this->addData($keyword, $value, true);

                //временно ищем слова перед которыми надо ставить +
                $this->queryModify->analyzeQuery($keyword);
            }

        //ищем ссылку на следующую страницу
        $this->next_page = '';
        foreach ($document->find('div.pages a') as $link) {
            $title = pq($link)->text();
            if (strpos($title, 'следующая') !== false)
                $this->next_page = 'http://wordstat.yandex.ru/' . pq($link)->attr('href');
        }

        if (!empty($this->next_page))
            $this->first_page = false;

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

            $model = Keyword::GetKeyword($keyword, 1, $value);
            $this->log('added: ' . $model->id);

            if ($related)
                KeywordRelation::saveRelation($this->keyword->keyword_id, $model->id);
        }
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
