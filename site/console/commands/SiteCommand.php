<?php
/**
 * Author: choo
 * Date: 14.05.2012
 */
class SiteCommand extends CConsoleCommand
{
    private $recipients = array(
        'choojoy.work@gmail.com',
        'alexk984@gmail.com',
        'lnghost@hotmail.com',
    );

    public function actionCheckSeo()
    {
        //robots
        $url = 'http://www.happy-giraffe.ru/robots.txt';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $robotsResult = $httpStatus == 200;

        //sitemap
        $url = 'http://www.happy-giraffe.ru/sitemap.xml';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $sitemapResult = simplexml_load_string($response) !== FALSE;

        $output =
            'robots.txt - ' . $robotsResult ? 'OK' : 'BROKEN' . "\n" .
                'sitemap.xml - ' . $sitemapResult ? 'OK' : 'BROKEN' . "\n"
        ;

        if (!($robotsResult && $sitemapResult)) {
            mail(implode(', ', $this->recipients), 'happy-giraffe.ru seo check failure', $output);
        }

        echo $output;
    }
}