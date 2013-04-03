<?php
/**
 * Class WordstatFilter
 *
 * Фильтр фраз через вордстат. Провяряет слова в вордстат, если не находит их в выдаче,
 * и при этом выдача не пустая, помечает это ключевое слово как плохое. Все что находит
 * помечает как хорошее. Проверяет только первую страницу
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class WordstatFilter extends WordstatBaseParser
{
    const CHECK_PRIORITY = 201;
    /**
     * @var ParsingKeyword[]
     */
    public $keywords = array();
    /**
     * @var ParsingKeyword
     */
    public $keyword = null;


    /**
     * Запуск парсинга
     * @param bool $mode тестовый или стардартный запуск
     */
    public function start($mode = false)
    {
        $this->init($mode);

        $fail_count = 0;
        while (true) {
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

    /**
     * Загрузка 100 ключевых слов
     */
    protected function loadKeywords()
    {
        $this->startTimer('load keywords');

        $criteria = new CDbCriteria;
        $criteria->condition = 'priority = '.self::CHECK_PRIORITY.' AND keyword_id % 645 = ' . $this->thread_id;
        $criteria->limit = 100;
        $this->keywords = ParsingKeyword::model()->findAll($criteria);

        $this->endTimer();
    }

    /**
     * Выбираем следующее ключевое слово
     */
    public function getKeyword()
    {
        if (empty($this->keywords))
            $this->loadKeywords();

        $this->keyword = array_shift($this->keywords);
    }

    /**
     * Парсим wordstat
     * @return bool успешно ли спарсилось
     */
    protected function parseQuery()
    {
        $this->getKeyword();
        $t = urlencode($this->queryModify->prepareQuery($this->keyword->keyword->name));

        $page = 'http://wordstat.yandex.ru/?cmd=words&page=1&t=' . $t . '&geo=&text_geo=';
        $this->log($page);

        $html = $this->query($page, 'http://wordstat.yandex.ru/');
        if (!isset($html) || $html === null)
            return false;

        return $this->parseHtml($html);
    }

    /**
     * Парсим html-документ, полученный от wordstat
     * @param $html string html-документ, полученный от wordstat
     * @return bool успешно ли спарсилось
     */
    public function parseHtml($html)
    {
        $this->log('parse page');
        $document = phpQuery::newDocument($html);

        //проверяем получена ли правильная страница и обновляем частоту wordstat текущего ключевого слова
        $wordstat_value = $this->getCurrentKeywordStat($html);
        echo "wordstat_value - $wordstat_value <br>";
        if ($wordstat_value !== false) {
            $this->keyword->updateWordstat($wordstat_value);
        } else
            return false;

        //парсим список ключевых слов в первом столбце
        $list = $this->getFirstKeywordsColumn($document);
        //проверяем есть ли в этом списке наше ключевое слово
        $this->checkList($list);
        foreach ($list as $value)
            $this->saveKeywordAsGood($value[0], $value[1]);

        $list = $this->getSecondKeywordsColumn($document);
        foreach ($list as $value)
            $this->saveKeywordAsGood($value[0], $value[1]);


        $document->unloadDocument();
        return true;
    }

    /**
     * Проверяем список выдачи для проверки есть ли там наше ключевое слово, если есть сохраняес как хорошее,
     * иначе как плохое
     * @param $list array
     */
    protected function checkList($list)
    {
        $status = KeywordStatus::STATUS_HIDE;
        foreach ($list as $value) {
            $keyword = $value[0];
            if ($this->keyword->keyword->name == $keyword) {
                $status = KeywordStatus::STATUS_GOOD;
                echo "found<br>";
                break;
            }
        }

        if (!empty($list))
            KeywordStatus::saveStatus($this->keyword->keyword_id, $status);

        $this->keyword->priority = 0;
        $this->keyword->update(array('priority'));
    }

    /**
     * Сохраняеем ключевое слово как хорошее, обновляем частоту
     * @param $keyword string
     * @param $wordstat_value int
     */
    protected function saveKeywordAsGood($keyword, $wordstat_value)
    {
        $model = Keyword::model()->findByAttributes(array('name' => $keyword));
        if ($model !== null) {
            echo "save - $keyword, $wordstat_value <br>";
            //save as good
            KeywordStatus::saveStatus($model->id, KeywordStatus::STATUS_GOOD);
            //update wordstat value
            $model->wordstat = $wordstat_value;
            $model->update(array('wordstat'));
            //update ParsingKeyword
            ParsingKeyword::wordstatParsed($model->id);
        }
    }
}
