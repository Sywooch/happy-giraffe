<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatSeasonParser extends WordstatBaseParser
{

    /**
     * Запуск потока-парсера. Связывается с поставщиком заданий и ждет появления новых заданий
     * @param bool $mode
     */
    public function start($mode = false)
    {
        $this->init($mode);

        Yii::app()->gearman->worker()->addFunction("simple_parsing", array($this, "processMessage"));
        while (Yii::app()->gearman->worker()->work()) ;
    }

    /**
     * Обработать поступившее задание
     * @param $job
     * @return bool
     */
    public function processMessage($job)
    {
        $id = $job->workload();
        $this->startTimer('parse keyword');
        $this->keyword = Keyword::model()->findByPk($id);
        if ($this->keyword !== null) {
            $this->log('Parsing keyword: ' . $this->keyword->id);
            $this->parse();
        }
        WordstatParsingTask::getInstance()->removeSimpleTask($id);

        $this->endTimer();
        return true;
    }

    /**
     * Парсинг сезонности ключевого слова
     */
    public function parse()
    {
        if ($this->keyword === null)
            return;

        $t = urlencode($this->queryModify->prepareQuery($this->keyword->name));
        $this->next_page = 'http://wordstat.yandex.ru/?cmd=months&page=1&t=' . $t . '&geo=&text_geo=';
        $this->prev_page = 'http://wordstat.yandex.ru/?cmd=months';

        while ($this->parseQuery() === false);
    }

    /**
     * Парсинг страницы
     * @return bool
     */
    protected function parseQuery()
    {
        $html = $this->query($this->next_page, $this->prev_page);
        if (!isset($html) || $html === null)
            return false;

        return $this->parseHtml($html);
    }

    public function parseHtml($html)
    {
        $this->log('parse page');

        $document = phpQuery::newDocument($html);
        $html = str_replace('&nbsp;', ' ', $html);
        $html = str_replace('&mdash;', '—', $html);

        //find and add our keyword
        if (strpos($html, 'Искомая комбинация слов нигде не встречается')) {
            $this->log('valid page loaded');
            $this->saveResult(0);
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
                    if (preg_match('/[\d]{2}.([\d]{2}).([\d]{4})/', $period, $matches)){
                        YandexPopularitySeason::addValue($this->keyword->keyword_id, $matches[1], $matches[2], pq($cell)->next()->text());
                        $sum += pq($cell)->next()->text();
                    }
                }

                $i++;
            }

            $this->saveResult(round($sum/24));
        }

        $document->unloadDocument();
        return true;
    }

    /**
     * Сохранить результат парсинга -
     * @param $value
     */
    public function saveResult($value)
    {
        $this->keyword->season_value = $value;
        $this->keyword->save();
    }
}
