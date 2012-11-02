<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/2/12
 * Time: 4:00 PM
 * To change this template use File | Settings | File Templates.
 */
class ParserCommand extends CConsoleCommand
{
    public function actionYandexVideo(array $queries, $pages = 50)
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');

        $res = array();
        foreach ($queries as $query) {
            for ($i = 0; $i <= $pages - 1; $i++) {
                $url = 'http://video.yandex.ru/ru/json/_search/?text=' . urlencode($query) . '&p=' . $i;
                $response = file_get_contents($url);
                $json = CJSON::decode($response);
                $html = $json['b-content-wrapper'];
                $doc = phpQuery::newDocumentXHTML($html, $charset = 'utf-8');
                foreach (pq('.b-video__host') as $e) {
                    $host = pq($e)->text();
                    (isset($res[$host])) ? $res[$host] += 1 : $res[$host] = 1;
                }
                $doc->unloadDocument();
            }
        }

        arsort($res, SORT_NUMERIC);
        foreach ($res as $k => $v)
            echo $k . ': ' . $v . "\n";
        echo 'Total: ' . array_sum($res);
    }
}
