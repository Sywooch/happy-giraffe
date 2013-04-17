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
     * @var Keyword
     */
    public $keyword = null;
    public $next_page = '';
    public $first_page = true;

    /**
     * Запуск потока-парсера. Связывается с поставщиком заданий и ждет появления новых заданий
     * @param bool $mode
     */
    public function start($mode = true)
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
        $this->keyword = Keyword::model()->findByPk($job->workload());
        if ($this->keyword == null)
            return true;
        $this->log('Parsing keyword: ' . $this->keyword->id);

        $this->checkName();
        $this->parse();
        return true;
    }

    /**
     * Временный метод проверки ключевого слова - нет ли там лишних символов
     */
    private function checkName()
    {
        $new_name = WordstatQueryModify::prepareForSave($this->keyword->name);
        if ($new_name != $this->keyword->name) {
            $this->keyword->name = $new_name;
            $model2 = Keyword::model()->findByAttributes(array('name' => $new_name));
            if ($model2 !== null) {
                try {
                    $this->keyword->delete();
                    $this->keyword = null;
                } catch (Exception $err) {
                }
            } else {
                try {
                    $this->keyword->save();
                } catch (Exception $err) {
                }
            }
        }
    }

    /**
     * Парсинг ключевого слова
     */
    public function parse()
    {
        if ($this->keyword === null)
            return ;

        $t = urlencode($this->queryModify->prepareQuery($this->keyword->name));
        $this->next_page = 'http://wordstat.yandex.ru/?cmd=words&page=1&t=' . $t . '&geo=&text_geo=';

        while(!empty($this->next_page)){
            $this->parseQuery();
            sleep(1);
        }
    }

    /**
     * Парсинг страницы
     * @return bool
     */
    protected function parseQuery()
    {
        $html = $this->query($this->next_page, 'http://wordstat.yandex.ru/');
        if (!isset($html) || $html === null)
            return false;

        return $this->parseHtml($html);
    }

    /**
     * Парсинг полученного документа
     * @param $html
     * @return bool
     */
    public function parseHtml($html)
    {
        $document = phpQuery::newDocument($html);

        $wordstat_value = $this->getCurrentKeywordStat($html);
        if ($wordstat_value !== false) {
            if ($this->first_page) {
                $this->keyword->wordstat = $wordstat_value;
                $this->keyword->update(array('wordstat', 'status'));
            }
        } else
            return false;
        $this->next_page = '';

        $list = $this->getFirstKeywordsColumn($document);
        foreach ($list as $value)
            $this->saveFoundKeyword($value[0], $value[1]);

        $list = $this->getSecondKeywordsColumn($document);
        foreach ($list as $value)
            $this->saveFoundKeyword($value[0], $value[1], true);

        //ищем ссылку на следующую страницу
        $this->findNextPageLink($document);

        if (!empty($this->next_page))
            $this->first_page = false;

        $document->unloadDocument();
        return true;
    }
}
