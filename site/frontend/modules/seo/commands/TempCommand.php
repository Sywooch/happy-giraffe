<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 18/07/14
 * Time: 14:26
 */

include_once \Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';



class TempCommand extends CConsoleCommand
{
    protected function getPathes($ga, $start, $end, $searchEngine)
    {
        $cacheId = 'Yii.seo.paths.' . $start . '.' . $end . '.' . $searchEngine;
        $paths = Yii::app()->cache->get($cacheId);
        if ($paths === false) {
            $ga->setDateRange($start, $end);
            $paths = $ga->getReport(array(
                'metrics' => 'ga:sessions',
                'dimensions' => 'ga:pagePath',
                'max-results' => 10000,
                'sort' => '-ga:sessions',
                'filters' => 'ga:source=@' . $searchEngine,
            ));
            Yii::app()->cache->set($cacheId, $paths);
        }
        return $paths;
    }

    public function actionStrong()
    {
        $patterns = array(
            '#\/community\/(?:\d+)\/forum\/(?:\w+)\/(\d+)\/$#',
            '#\/user\/(?:\d+)\/blog\/post(\d+)\/$#',
        );
        $result = array();

        $ga = new \GoogleAnalytics('nikita@happy-giraffe.ru', 'ummvxhwmqzkrpgzj');
        $ga->setProfile('ga:53688414');

        $paths = $this->getPathes($ga, '2014-05-19', '2014-05-19', 'google');
        foreach ($paths as $path => $value) {
            $result[$path] = array(
                'period1' => $value['ga:sessions'],
                'period2' => 0,
            );
        }

        $paths = $this->getPathes($ga, '2014-06-16', '2014-06-16', 'google');
        foreach ($paths as $path => $value) {
            if (isset($result[$path])) {
                $result[$path]['period2'] = $value['ga:sessions'];
            } else {
                $result[$path] = array(
                    'period1' => 0,
                    'period2' => $value['ga:sessions'],
                );
            }
        }

        foreach ($paths as $path => $value) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $path, $matches) == 1) {
                    $id = $matches[1];
                    $post = \CommunityContent::model()->findByPk($id);
                    $text = $post->getContent()->text;
                    $dom = str_get_html($text);
                    $result[$path]['url'] = $path;
                    $result[$path]['title'] = $post->title;
                    $result[$path]['strong'] = count($dom->find('strong'));
                    $result[$path]['em'] = count($dom->find('em'));
                }
            }
        }
    }
} 