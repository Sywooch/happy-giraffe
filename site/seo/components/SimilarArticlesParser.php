<?php
/**
 * Author: alexk984
 * Date: 25.06.12
 */
class SimilarArticlesParser
{
    /**
     * @param string $keyword
     * @return Page[]
     */
    public function getArticles($keyword)
    {
        if ($this->startsWith($keyword, 'http://'))
            $content = $this->query('http://yandex.ru/yandsearch?text=site%3A' . urlencode($keyword) . '&lr=38&numdoc=30&lang=ru');
        else
            $content = $this->query('http://yandex.ru/yandsearch?text=site%3Ahttp%3A%2F%2Fwww.happy-giraffe.ru%2F+' . urlencode($keyword) . '&lr=38&numdoc=30&lang=ru');

        $document = phpQuery::newDocument($content);
        $links = array();
        foreach ($document->find('.b-body-items  h2 a.b-serp-item__title-link') as $link) {
            $links [] = pq($link)->attr('href');
        }

        $pages = array();
        foreach($links as $link){
            $pages[] = Page::model()->getOrCreate($link);
        }

        return $pages;
    }

    protected function getCookieFile()
    {
        return Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR . 'similar-articles.txt';
    }

    protected function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    protected function query($url)
    {
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0');

            $best = '46.165.200.102:999
46.165.200.104:999
78.159.102.95:999
89.149.242.87:999
62.212.72.237:999
89.149.254.167:999
31.184.192.89:999
95.211.156.223:999
95.211.156.222:999
95.211.159.76:999
95.211.189.193:999
95.211.189.194:999
95.211.189.195:999
95.211.189.196:999
95.211.189.197:999
83.136.86.192:999
217.79.179.100:999
95.211.189.218:999';
            $best_proxies = explode("\n", $best);
            $i = rand(0, count($best_proxies) - 1);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $best_proxies[$i]);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia1111");
            curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->getCookieFile());
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->getCookieFile());
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);

            $content = curl_exec($ch);

            if ($content !== false)
                return $content;
        }

        return '';
    }
}
