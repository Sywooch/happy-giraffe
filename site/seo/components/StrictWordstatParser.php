<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class StrictWordstatParser extends WordstatParser
{

    public function getNextPage()
    {
        if (empty($this->next_page)) {
            $this->getKeyword();
            $t = urlencode($this->queryModify->prepareStrictQuery($this->keyword->keyword->name));

            $this->next_page = 'http://wordstat.yandex.ru/?cmd=words&page=1&t=' . $t . '&geo=&text_geo=';
            $this->log($this->next_page);
        }
    }

    public function loadKeywords()
    {
        $this->startTimer('load keywords');

        //сначала загружаем приоритетные фразы
        $criteria = new CDbCriteria;
        $criteria->condition = 'priority = 255 AND keyword_id % 645 = ' . $this->thread_id;
        $criteria->order = 'priority desc';
        $criteria->limit = 100;
        $this->keywords = ParsingKeyword::model()->findAll($criteria);

        $this->log(count($this->keywords) . ' priority keywords loaded');

        $this->endTimer();
    }

    public function parseData($html)
    {
        $this->log('parse page');

        $document = phpQuery::newDocument($html);
        $html = str_replace('&nbsp;', ' ', $html);
        $html = str_replace('&mdash;', '—', $html);

        $wordstat_value = $this->getCurrentKeywordStat($html);
        if ($wordstat_value !== false){
            if ($this->first_page)
                $this->saveCurrentKeyword($wordstat_value);
        }else
            return false;

        $this->next_page = '';

        $document->unloadDocument();
        return true;
    }

    /**
     * Сохраняем статистику ключевого слова
     * @param $value
     */
    protected function saveCurrentKeyword($value)
    {
        $strict_wordstat = KeywordStrictWordstat::model()->findByPk($this->keyword->keyword_id);

        if ($strict_wordstat === null) {
            $strict_wordstat = new KeywordStrictWordstat;
            $strict_wordstat->keyword_id = $this->keyword->keyword_id;
            $strict_wordstat->wordstat = $this->keyword->keyword->wordstat;
            $strict_wordstat->strict_wordstat = $value;
            $strict_wordstat->save();
        } else {
            $strict_wordstat->wordstat = $this->keyword->keyword->wordstat;
            $strict_wordstat->strict_wordstat = $value;
            $strict_wordstat->save();
        }

        if (empty($value) || $this->keyword->keyword->wordstat / $value > 1000) {
            $this->keyword->keyword->wordstat = $value;
            try {
                $this->keyword->keyword->save();
            } catch (Exception $err) {
                return;
            }
        }
        $this->keyword->priority = 0;
        $this->keyword->update(array('priority'));
    }
}
