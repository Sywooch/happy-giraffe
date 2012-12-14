<?php
/**
 * Author: alexk984
 * Date: 25.06.12
 */

Yii::import('site.frontend.modules.cook.models.*');
class SimilarArticlesParser
{
    const SITE_ID = 1979555;
    /**
     * @param string $keyword
     * @return Page[]
     */
    public function getArticles($keyword)
    {
        //test
        if ($this->startsWith($keyword, 'http://')) {
            $content = $this->query('http://yandex.ru/sitesearch?text=url%3A' . urlencode($keyword) . '*&searchid='.self::SITE_ID.'&reqenc=utf-8&l10n=ru&web=0&lr=38&numdoc=50');
        } else
            $content = $this->query('http://yandex.ru/sitesearch?text=' . urlencode($keyword) . '&searchid='.self::SITE_ID.'&reqenc=utf-8&l10n=ru&web=0&lr=38&numdoc=50');

        $document = phpQuery::newDocument($content);
        $links = array();
        foreach ($document->find('h3.b-serp-item__title a.b-serp-item__title-link') as $link) {
            $url = pq($link)->attr('href');
            if (strpos($url, 'http://www.happy-giraffe.ru/') !== false)
                $links [] = pq($link)->attr('href');
        }
        $document->unloadDocument();

        $pages = array();
        foreach ($links as $link)
            if (strpos($link, '?Comment_page=') === false) {
                $p = Page::model()->getOrCreate($link);
                if ($p)
                    $pages[] = $p;
            }


        $keyword_model = Keyword::model()->find('name="' . $keyword . '"');
        if ($keyword_model !== null)
            foreach ($pages as $page) {
                $model = new YandexSearchResult;
                $model->keyword_id = $keyword_model->id;
                $model->page_id = $page->id;
                $model->save();
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
            curl_setopt($ch, CURLOPT_REFERER, 'http://www.happy-giraffe.ru/');

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
//            $best_proxies = explode("\n", $best);
//            $i = rand(0, count($best_proxies) - 1);
//            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
//            curl_setopt($ch, CURLOPT_PROXY, $best_proxies[$i]);
//            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia1111");
//            curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
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
