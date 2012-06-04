<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatParser extends ProxyParserThread
{
    public $cookie;
    public $keywords = array(
        'беременность',
        //'беременность по неделям'
    );

    public $result = array();

    public function start()
    {
        $this->delay_min = 0;
        $this->delay_max = 0;

        $this->getCookie();

        for ($i = 0; $i < count($this->keywords); $i++) {
            $success = false;
            while (!$success) {
                $success = $this->parseQuery($this->keywords[$i]);
                if (!$success)
                    $this->changeBadProxy();
            }

            if (Config::getAttribute('stop_threads') == 1)
                break;
        }

        var_dump($this->result);
    }

    public function afterProxyChange()
    {
        $this->getCookie();
    }

    private function getCookie()
    {
        $url = 'http://wordstat.yandex.ru/';
        $mc_url = '';

        while (empty($mc_url)) {
            $data = $this->query($url);

            if (preg_match('/<img src="\/\/mc.yandex.ru\/watch\/([\d]+)"/', $data, $res)) {
                $mc_url = 'http://mc.yandex.ru/watch/' . $res[1];
                $this->query($mc_url, $url);
                echo $mc_url;
            }
            $this->query('http://kiks.yandex.ru/su/', $url);
        }
    }

    private function parseQuery($query)
    {
        if (isset($this->result[$query]))
            return true;

        $html = $this->query('http://wordstat.yandex.ru/?cmd=words&page=1&t=' . urlencode($query) . '&geo=&text_geo=', 'http://wordstat.yandex.ru/');

        if (!strpos($html, 'Что искали со')){
            echo $html;
            return false;
        }

        $document = phpQuery::newDocument($html);
        foreach ($document->find('table.campaign tr td table td a') as $link) {
            $keywords = pq($link)->text();
            $value = (int)pq($link)->parent()->next()->next()->text();
            $this->AddStat($keywords, $value);
        }

        return true;
    }

    public function AddStat($keyword, $value)
    {
        if (!empty($keyword) && !empty($value))
            $this->result[$keyword] = $value;
    }
}
