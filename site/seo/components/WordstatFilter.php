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
            $this->getKeyword();

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
        $criteria->condition = 'priority = ' . self::CHECK_PRIORITY . ' AND keyword_id % 645 = ' . $this->thread_id;
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
        $this->log("wordstat_value - $wordstat_value \n");
        if ($wordstat_value !== false) {
            $this->keyword->updateWordstat($wordstat_value);
        } else
            return false;

        //парсим список ключевых слов в первом столбце
        $list = $this->getFirstKeywordsColumn($document);
        //проверяем есть ли в этом списке наше ключевое слово
        $status = $this->checkList($list);

        //обрабатываем найденные слова только если слово хорошее, чтобы сократить издержки на повторы
        if ($status != Keyword::STATUS_HIDE) {
            foreach ($list as $value)
                $this->saveKeywordAsGood($value[0], $value[1]);

            $list = $this->getSecondKeywordsColumn($document);
            foreach ($list as $value)
                $this->saveKeywordAsGood($value[0], $value[1], true);
        }

        $document->unloadDocument();
        return true;
    }

    /**
     * Проверяем список выдачи для проверки есть ли там наше ключевое слово, если есть сохраняес как хорошее,
     * иначе как плохое
     * @param $list array
     * @return int статус слова
     */
    protected function checkList($list)
    {
        $status = Keyword::STATUS_HIDE;
        foreach ($list as $value) {
            $keyword = $value[0];
            if ($this->keyword->keyword->name == $keyword) {
                $status = Keyword::STATUS_GOOD;
                $this->log("found\n");
                break;
            }
        }

        if (!empty($list))
            $this->keyword->keyword->saveStatus($status);
        else
            $this->keyword->keyword->saveStatus(Keyword::STATUS_UNDEFINED);

        $this->keyword->priority = 0;
        $this->keyword->update(array('priority'));

        return $status;
    }

    /**
     * Сохраняеем ключевое слово как хорошее, обновляем частоту
     * @param $keyword string
     * @param $wordstat_value int
     * @param bool $related
     */
    protected function saveKeywordAsGood($keyword, $wordstat_value, $related = false)
    {
        $model = Keyword::model()->findByAttributes(array('name' => $keyword));
        if ($model !== null) {
            $this->log("save - $keyword, $wordstat_value \n");
            //save as good and update wordstat value
            $model->wordstat = $wordstat_value;
            $model->saveStatus(Keyword::STATUS_GOOD);
            //update ParsingKeyword
            ParsingKeyword::wordstatParsed($model->id);
        } else {
            $model = new Keyword;
            $model->name = $keyword;
            $model->wordstat = $wordstat_value;
            $model->status = Keyword::STATUS_GOOD;
            try {
                $model->save();
                $parsing_model = new ParsingKeyword();
                $parsing_model->keyword_id = $model->id;
                $parsing_model->priority = 0;
                $parsing_model->updated = date("Y-m-d H:i:s");
                $parsing_model->save();
            } catch (Exception $err) {
            }
        }

        if ($related && isset($model->id))
            KeywordRelation::saveRelation($this->keyword->keyword_id, $model->id);
    }

    /**
     * Тестирование класса
     */
    public static function Test()
    {
        $html = file_get_contents('f:/test_page.html');
        $parser = new WordstatFilter(1);
        $parser->keyword = ParsingKeyword::model()->findByPk(243629017);
        $parser->debug = true;
        $parser->queryModify = new WordstatQueryModify;
        $parser->parseHtml($html);
    }
}
