<?php
/**
 * Class WordstatParser
 *
 * Стандартный парсер вордстат, парсит частоту и собирает дополнительный ключевые слова, которые находит
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class WordstatParser extends WordstatBaseParser
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

    public function start($mode = false)
    {
        $this->init($mode);
        
        $fail_count = 0;
        while (true) {
            $this->getNextPage();

            $success = false;
            while (!$success) {
                $success = $this->parseQuery();

                if (!$success) {
                    $fail_count++;
                    if ($fail_count > 10) {
                        $this->removeCookieFile();
                        $this->getCookie();
                        $fail_count = 0;
                    } else
                        $this->changeBadProxy();
                } else {
                    $this->success_loads++;
                    $fail_count = 0;
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
            $this->log($this->next_page);
        }
    }

    public function loadKeywords()
    {
        $this->startTimer('load keywords');

        //сначала загружаем приоритетные фразы
        $criteria = new CDbCriteria;
        $criteria->condition = 'priority > 0 AND keyword_id % 645 = ' . $this->thread_id;
        $criteria->order = 'priority desc';
        $criteria->limit = 100;
        $this->keywords = ParsingKeyword::model()->findAll($criteria);

        if (empty($this->keywords)) {
            if ($this->parsing_type == self::TYPE_STRICT)
                Yii::app()->end();
            //если нет приоритетных загружаем остальные
            $criteria = new CDbCriteria;
            $criteria->limit = 100;
            $criteria->order = 'updated asc';

            $this->keywords = ParsingKeyword::model()->findAll($criteria);
            $this->log(count($this->keywords) . ' keywords with 0 priority loaded');
        } else {
            $this->log(count($this->keywords) . ' priority keywords loaded');
        }

        $this->endTimer();
    }

    public function getKeyword()
    {
        $this->first_page = true;

        if (empty($this->keywords))
            $this->loadKeywords();

        $this->keyword = array_shift($this->keywords);

        //check name
        if (!isset($this->keyword->keyword))
            $this->getKeyword();

        $new_name = WordstatQueryModify::prepareForSave($this->keyword->keyword->name);
        if ($new_name != $this->keyword->keyword->name) {
            $this->keyword->keyword->name = $new_name;
            $model2 = Keyword::model()->findByAttributes(array('name' => $new_name));
            if ($model2 !== null) {
                try {
                    $this->keyword->keyword->delete();
                } catch (Exception $err) {
                }
                $this->getKeyword();
            } else {
                try {
                    $this->keyword->keyword->save();
                } catch (Exception $err) {
                }
            }
        }
        $this->log('Parsing keyword: ' . $this->keyword->keyword_id);
    }

    protected function parseQuery()
    {
        $html = $this->query($this->next_page, 'http://wordstat.yandex.ru/');
        if (!isset($html) || $html === null)
            return false;

        return $this->parseHtml($html);
    }


    public function parseHtml($html)
    {
        $this->log('parse page');
        $document = phpQuery::newDocument($html);

        $wordstat_value = $this->getCurrentKeywordStat($html);
        if ($wordstat_value !== false){
            if ($this->first_page)
                $this->keyword->updateWordstat($wordstat_value);
        }else
            return false;
        $this->next_page = '';

        $list = $this->getFirstKeywordsColumn($document);
        foreach($list as $value)
            $this->saveFoundKeyword($value[0], $value[1]);

        $list = $this->getSecondKeywordsColumn($document);
        foreach($list as $value)
            $this->saveFoundKeyword($value[0], $value[1], true);

        //ищем ссылку на следующую страницу
        $this->findNextPageLink($document);

        if (!empty($this->next_page))
            $this->first_page = false;

        $document->unloadDocument();
        return true;
    }
}
