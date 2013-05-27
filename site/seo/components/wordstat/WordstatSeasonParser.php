<?php
/**
 * Class WordstatSeasonParser
 *
 * Парсер сезонности вордстат
 *
 * @author Alex Kireev <alexk984@gmail.com>
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

        Yii::app()->gearman->worker()->addFunction("season_parsing", array($this, "processMessage"));
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
        WordstatParsingTask::getInstance()->removeSimpleTask($id, 'season_parsing');

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

        while ($this->parseQuery() === false) ;
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

    /**
     * Парсинг полученного документа
     *
     * @param $html string html-документ
     * @return bool успешность
     */
    public function parseHtml($html)
    {
        $this->log('parse page');

        $document = phpQuery::newDocument($html);
        $html = str_replace('&nbsp;', ' ', $html);
        $html = str_replace('&mdash;', '—', $html);

        if (strpos($html, 'Искомая комбинация слов нигде не встречается')) {
            $this->log('data not found', true);
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
                        WordstatSeason::getInstance()->add($this->keyword->id, $matches[1], $matches[2], pq($cell)->next()->text());
                        $sum += pq($cell)->next()->text();

                        $this->log($this->keyword->id . $matches[1] . $matches[2], true);
                    }
                }

                $i++;
            }

            $this->log('data found', true);
        }

        $document->unloadDocument();
        return true;
    }
}
