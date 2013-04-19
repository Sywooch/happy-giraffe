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
    public $first_page = true;

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
        $this->keyword = Keyword::model()->findByPk($id);
        if ($this->keyword === null)
            return true;
        $this->log('Parsing keyword: ' . $this->keyword->id);

        $this->checkName();
        $this->parse();
        WordstatParsingTask::getInstance()->removeSimpleTask($id);
        return true;
    }

    /**
     * Временный метод проверки ключевого слова - нет ли там лишних символов
     */
    private function checkName()
    {
        //сначала проверяем регистр и пересохраняем если необходимо
        $low_name = mb_strtolower($this->keyword->name, 'utf-8');
        if ($this->keyword->name !== $low_name) {
            $this->keyword->name = $low_name;
            $this->keyword->update(array('name'));
        }

        $new_name = WordstatQueryModify::prepareForSave($this->keyword->name);

        if ($new_name !== $this->keyword->name) {
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
            return;

        $t = urlencode($this->queryModify->prepareQuery($this->keyword->name));
        $this->next_page = 'http://wordstat.yandex.ru/?cmd=words&page=1&t=' . $t . '&geo=&text_geo=';
        $this->first_page = true;
        $this->prev_page = 'http://wordstat.yandex.ru/';

        while (!empty($this->next_page)) {
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
        $html = $this->query($this->next_page, $this->prev_page);
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
            if ($this->first_page)
                $this->keyword->wordstat = $wordstat_value;
        } else {
            $document->unloadDocument();
            return false;
        }

        //увеличиваем счетчик успешных загрузок страницы
        $this->success_loads++;
        //готовим referrer для получения следуюей страницы
        $this->prev_page = $this->next_page;
        //ищем ссылку на следующую страницу
        $this->findNextPageLink($document);

        //парсим первую колонку
        $list = $this->getFirstKeywordsColumn($document);
        if ($this->first_page)
            $this->checkKeywordStatus($list);

        foreach ($list as $value)
            $this->saveFoundKeyword($value[0], $value[1]);

        //если статус не хороший, то не парсим остальные страницы
        if ($this->keyword->status != Keyword::STATUS_GOOD) {
            $document->unloadDocument();
            return true;
        }

        //парсим вторую колонку
        if ($this->first_page) {
            $list = $this->getSecondKeywordsColumn($document);
            foreach ($list as $value)
                $this->saveFoundKeyword($value[0], $value[1], true);
        }

        if ($this->first_page)
            $this->keyword->update(array('wordstat', 'status'));

        $this->first_page = false;
        $document->unloadDocument();
        return true;
    }

    /**
     * Проверяем список выдачи для проверки есть ли там наше ключевое слово, если есть сохраняем как хорошее,
     * иначе как плохое. Если список пустой - сохраняем как UNDEFINED
     * @param $list array
     */
    protected function checkKeywordStatus($list)
    {
        $status = Keyword::STATUS_HIDE;
        foreach ($list as $value) {
            $keyword = $value[0];
            if ($this->keyword->name == $keyword) {
                $status = Keyword::STATUS_GOOD;
                $this->log("found\n");
                break;
            }
        }

        if (!empty($list))
            $this->keyword->status = $status;
        else
            $this->keyword->status = Keyword::STATUS_UNDEFINED;
    }

    /**
     * Сохраняем найденные ключевые слова
     *
     * @param $keyword string ключевое слово
     * @param $value int значение частоты wordstat
     * @param $related bool добавть в связи или нет
     * @return Keyword|null
     */
    protected function saveFoundKeyword($keyword, $value, $related = false)
    {
        if (!empty($keyword) && !empty($value)) {
            if (strpos($keyword, '+') !== false) {
                $keyword = str_replace(' +', ' ', $keyword);
                $keyword = ltrim($keyword, '+');
            }

            $model = Keyword::model()->findByAttributes(array('name' => $keyword));
            if ($model !== null) {
                $this->log('keyword: ' . $model->id . ' - ' . $model->wordstat);
                $model->wordstat = $value;
                $model->status = Keyword::STATUS_GOOD;
                $model->save();
                //удаляем из очереди на парсинг если во фразе больше 3-х слов
                if (substr_count($keyword, ' ') > 2) {
                    $this->log('remove keyword ' . $model->id . ' from parsing queue');
                    WordstatParsingTask::getInstance()->removeSimpleTask($model->id);
                }
            } else {
                $this->log('new keyword found: ' . $keyword);

                //добавлеяем новое ключевое слово
                $model = new Keyword();
                $model->name = $keyword;
                $model->wordstat = $value;
                $model->status = Keyword::STATUS_GOOD;
                try {
                    $model->save();
                    //если во фразе кол-во слов <= 3 добавляем его на парсинг
                    if (substr_count($keyword, ' ') <= 2) {
                        $this->log('add keyword ' . $model->id . ' to parsing queue');
                        WordstatParsingTask::getInstance()->addSimpleTask($model->id);
                    }

                } catch (Exception $err) {
                    $this->log('error while keyword adding ' . $err->getMessage());
                }
            }

            if ($related && $model && isset($model->id))
                KeywordRelation::saveRelation($this->keyword->id, $model->id);
        }
    }
}
