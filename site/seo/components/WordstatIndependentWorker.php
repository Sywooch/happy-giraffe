<?php
/**
 * Class WordstatIndependentWorker
 *
 * Работник который парсит переданное ему ключевое слово
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class WordstatIndependentWorker extends WordstatBaseParser
{
    const TYPE_SIMPLE = 1;
    const TYPE_QUOTES = 2;
    const TYPE_STRICT = 3;
    /**
     * @var Keyword
     */
    private $keyword;
    public $wordstat_type = self::TYPE_SIMPLE;
    private $initialized = false;

    function __construct()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $this->getProxy();
    }

    /**
     * @param $keyword Keyword
     * @param $mode bool
     * @return int
     */
    public function parseWordstat($keyword, $mode = false)
    {
        if (!$this->initialized) {
            $this->init($mode);
            $this->initialized = true;
        }

        $this->keyword = $keyword;

        if ($this->wordstat_type == self::TYPE_SIMPLE)
            $t = urlencode($this->queryModify->prepareQuery($this->keyword->name));
        elseif ($this->wordstat_type == self::TYPE_QUOTES)
            $t = urlencode($this->queryModify->prepareQuotesQuery($this->keyword->name));
        elseif ($this->wordstat_type == self::TYPE_STRICT)
            $t = urlencode($this->queryModify->prepareStrictQuery($this->keyword->name));

        $url = 'http://wordstat.yandex.ru/?cmd=words&page=1&t=' . $t . '&geo=&text_geo=';
        return $this->parsePage($url);
    }

    /**
     * @param $url string
     * @return bool|int
     */
    private function parsePage($url)
    {
        $result = false;
        while ($result === false){
            $html = $this->query($url, 'http://wordstat.yandex.ru/');
            $result = $this->parseHtml($html);
            if ($result === false)
                $this->changeBadProxy();
        }

        return $result;
    }

    /**
     * @param $html string
     * @return bool|int
     */
    private function parseHtml($html)
    {
        $document = phpQuery::newDocument($html);
        $wordstat_value = $this->getCurrentKeywordStat($html);
        $document->unloadDocument();

        return $wordstat_value;
    }
}
