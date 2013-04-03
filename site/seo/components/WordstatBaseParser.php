<?php
/**
 * Class WordstatBaseParser
 *
 * Базовый класс для различных парсеров http://wordstat.yandex.ru/
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class WordstatBaseParser extends ProxyParserThread
{
    /**
     * @var WordstatQueryModify
     */
    public $queryModify;

    public function init($mode)
    {
        $this->debug = $mode;
        $this->queryModify = new WordstatQueryModify;
        $this->removeCookieOnChangeProxy = false;

        $this->getCookie();
    }

    /**
     * Получение cookie для дальнейшей работы
     */
    protected function getCookie()
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

    /**
     * Получает значение частоты ключевого слова, введенного в вордстат
     *
     * @param $html string html-код полученной страницы
     * @return bool
     */
    protected function getCurrentKeywordStat($html)
    {
        $html = str_replace('&nbsp;', ' ', $html);
        $html = str_replace('&mdash;', '—', $html);

        if (preg_match('/— ([\d]+) показ[ов]*[а]* в месяц/', $html, $matches)) {
            $this->log('valid page loaded');

            $this->log('wordstat value: ' . $matches[1]);
            return $matches[1];
        } else
            return false;
    }

    /**
     * Возвращает список ключевых слов из первого столбца wordstat "Что искали со словами"
     * @param $document phpQueryObject документ резульатов поиска
     * @return array
     */
    protected function getFirstKeywordsColumn($document)
    {
        $list = array();
        foreach ($document->find('table.campaign tr td table:first td a') as $link) {
            $keyword = trim(pq($link)->text());
            $value = (int)pq($link)->parent()->next()->next()->text();

            //временно ищем слова перед которыми надо ставить +
            $this->queryModify->analyzeQuery($keyword);
            //убираем + из фраз
            $keyword = str_replace('+', '', $keyword);

            $list [] = array($keyword, $value);
        }

        return $list;
    }

    /**
     * Возвращает список ключевых слов из второго столбца wordstat "Что еще искали люди, искавшие"
     * @param $document phpQueryObject документ резульатов поиска
     * @return array
     */
    protected function getSecondKeywordsColumn($document)
    {
        $list = array();
        foreach ($document->find('table.campaign tr td table:eq(1) td a') as $link) {
            $keyword = trim(pq($link)->text());
            $value = (int)pq($link)->parent()->next()->next()->text();

            //временно ищем слова перед которыми надо ставить +
            $this->queryModify->analyzeQuery($keyword);
            //убираем + из фраз
            $keyword = str_replace('+', '', $keyword);

            $list [] = array($keyword, $value);
        }

        return $list;
    }

    /**
     * Ищем ссылку на следующую страницу и сохраняем ее если нашли
     * @param $document phpQueryObject документ резульатов поиска
     */
    protected function findNextPageLink($document)
    {
        foreach ($document->find('div.pages a') as $link) {
            $title = pq($link)->text();
            if (strpos($title, 'следующая') !== false)
                $this->next_page = 'http://wordstat.yandex.ru/' . pq($link)->attr('href');
        }
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

            $model = Keyword::GetKeyword($keyword, 0, $value);
            if ($model !== null) {
                if ($related)
                    KeywordRelation::saveRelation($this->keyword->keyword_id, $model->id);
                return $model;
            }
        }

        return null;
    }
}
