<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatController extends SController
{
    public $cookie = '';
    public $session = 1;

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $parser = new WordstatParser;
        $parser->start();

//        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
//
//        $this->getCookie('http://wordstat.yandex.ru/');
//        $this->startParse();
    }

    public function actionPrepareKeywords(){
        $allSearch = Yii::app()->search
            ->select('*')
            ->from('keywords')
            ->where('*роды*')
            ->limit(0, 1000)
            ->searchRaw();
        echo count($allSearch['matches']);
    }

    public function getCookie($url)
    {
        $data = $this->loadPage($url, '');
        //echo $data;Yii::app()->end();
        if (preg_match('/<img src="\/\/mc.yandex.ru\/watch\/([\d]+)"/', $data, $res)) {
            $mc_url = 'http://mc.yandex.ru/watch/' . $res[1];
            $data2 = $this->loadPage($mc_url, $url);
            if (preg_match('/Set-Cookie: ([^;]+;) domain=.yandex.ru/', $data2, $res)) {
                $cookie = $res[1] . ' ';
            }

        }
        $data2 = $this->loadPage('http://kiks.yandex.ru/su/', $url);
        if (preg_match('/Set-Cookie: ([^;]+;) domain=.yandex.ru/', $data2, $res)) {
            $cookie .= $res[1];
        }

        $this->cookie = $cookie;
    }

    public function startParse()
    {
        $keyword = urlencode('бэбиблог');
        $url = 'http://wordstat.yandex.ru/?cmd=words&page=1&t=' . $keyword . '&geo=&text_geo=';
        $html = $this->loadPage($url, 'http://wordstat.yandex.ru/');
        //echo $html;

        $document = phpQuery::newDocument($html);
        foreach ($document->find('table.campaign tr td table td a') as $link) {
            echo pq($link)->text();
            echo pq($link)->parent()->next()->next()->text();
            echo '<br>';
        }
    }

    public function loadPage($url, $ref)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $ref);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($this->cookie))
            curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0');
        return curl_exec($ch);
    }

    public function getKeyword()
    {

    }
}
