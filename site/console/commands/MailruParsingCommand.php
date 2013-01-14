<?php
/**
 * Author: alexk984
 * Date: 28.11.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.modules.competitors.models.*');
Yii::import('site.seo.modules.writing.models.*');
Yii::import('site.seo.modules.promotion.models.*');

class MailruParsingCommand extends CConsoleCommand
{
    const STATS_LIMIT = 5;
    public $proxy = '';
    public $proxy_list = array(
        '46.165.200.102:777',
        '46.165.200.104:777',
        '95.211.156.222:777',
        '95.211.159.76:777',
        '95.211.189.193:777',
        '95.211.189.194:777',
        '95.211.189.195:777',
        '95.211.189.196:777',
        '95.211.189.197:777',
        '95.211.189.218:777',
        '95.211.193.40:777',
        '46.165.200.108:777',
        '46.165.200.115:777',
        '46.165.200.116:777',
        '46.165.200.117:777',
        '46.165.200.118:777',
        '94.242.251.218:777');

    public function actionParse($site_id)
    {
        $this->proxy = $this->proxy_list[$site_id % 16];
        $this->parseStats($site_id, 2011, 1, 12, 0);
        $this->parseStats($site_id, 2012, 1, 11, 0);
    }

    public function parseStats($site_id, $year, $month_from, $month_to)
    {
        $site = $this->loadModel($site_id);

        for ($month = $month_from; $month <= $month_to; $month++) {
            $url = 'http://top.mail.ru/keywords?id=' . $site->url . '&period=2&date='.$year.'-' . $month . '-01&pp=200&gender=0&agegroup=0&searcher=all&sf=';

            $i = 0;
            $count = 1;
            while (!empty($count)) {
                $page_url = $url . ($i * 200);
                $result = $this->loadPage($page_url, '');

                $document = phpQuery::newDocument($result);
                $count = $this->ParseDocument($document, $month, $year, $site_id);

                sleep(1);
                $i++;
            }

            echo $site_id.' month '.$month.' finished'."\n";
        }

        return true;
    }

    public function loadPage($page_url, $last_url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:16.0) Gecko/20100101 Firefox/16.0');
        curl_setopt($ch, CURLOPT_URL, $page_url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        if (!empty($last_url))
            curl_setopt($ch, CURLOPT_REFERER, $last_url);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->getCookieFile());
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->getCookieFile());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        if (!in_array(getenv('SERVER_ADDR'), array('5.9.7.81', '88.198.24.104'))) {
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia12345");
            curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $content = curl_exec($ch);
        curl_close($ch);

        if ($content === false)
            return $this->loadPage($page_url, $last_url);
        else {
            if (!strpos($content, iconv("UTF-8", "Windows-1251", 'рейтинг mail.ru'))) {
                echo "page is not mail.ru \n";
                return $this->loadPage($page_url, $last_url);
            }
            return $content;
        }
    }

    public function getCookieFile()
    {
        $filename = Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR . 'mailru.txt';

        return $filename;
    }

    private function ParseDocument($document, $month, $year, $site_id)
    {
        $count = 0;
        foreach ($document->find('div.listing_projects table.t1 tr') as $row) {
            $keyword = trim(pq($row)->find('td:eq(2)')->text());
            if (empty($keyword) || $keyword == 'другие запросы')
                continue;

            $keyword = substr($keyword, 3);

            $stats = trim(pq($row)->find('td:eq(0)')->text());
            $stats = str_replace(',', '', $stats);
            if ($stats < self::STATS_LIMIT)
                return false;

            $keyword_model = Keyword::GetKeyword($keyword);
            if ($keyword_model !== null) {
                SiteKeywordVisit::SaveValue($site_id, $keyword_model->id, $month, $year, $stats);
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param int $id model id
     * @return Site
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Site::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
