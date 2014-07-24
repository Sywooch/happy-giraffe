<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 18/07/14
 * Time: 15:05
 */

include_once \Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';
Yii::import('site.frontend.extensions.GoogleAnalytics');

class SeoTempCommand extends CConsoleCommand
{
    protected function getPathes($start, $end, $searchEngine)
    {
        $ga = new GoogleAnalytics('nikita@happy-giraffe.ru', 'ummvxhwmqzkrpgzj');
        $ga->setProfile('ga:53688414');

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

    public function actionRemoved()
    {
        $patterns = array(
            '#\/community\/(?:\d+)\/forum\/(?:\w+)\/(\d+)\/$#',
            '#\/user\/(?:\d+)\/blog\/post(\d+)\/$#',
        );

        $result = array();
        $paths = $this->getPathes('2014-02-04', '2014-02-04', 'google');
        foreach ($paths as $path => $value) {
            if ($value['ga:sessions'] > 50) {
                foreach ($patterns as $pattern) {
                    if (preg_match($pattern, $path, $matches)) {
                        $id = $matches[1];
                        $post = \CommunityContent::model()->resetScope()->findByPk($id);

                        if ($post === null) {
                            echo $path . "\n";
                            continue;
                        }

                        $result[] = array('http://www.happy-giraffe.ru' . $path, $value['ga:sessions'], $post->removed);
                    }
                }
            }
        }

        $this->writeCsv('removed', $result);
    }

    public function actionReplaceTag($from, $to)
    {
        $result = array();
        $dp = new CActiveDataProvider('CommunityPost', array(
            'criteria' => array(
                'with' => 'content',
                'condition' => 'content.removed = 0 AND content.id = 43301',
            ),
        ));
        $iterator = new CDataProviderIterator($dp, 1000);
        foreach ($iterator as $post) {
            echo $post->id . "\n";
            if ($dom = str_get_html($post->text)) {
                $els = $dom->find($from);
                foreach ($els as $el) {
                    $el->outertext = '<' . $to . '>' . $el->innertext . '</' . $to . '>';
                    CommunityPost::model()->updateByPk($post->id, array('text' => (string) $dom));
                    $post->purified->clearCache();

                    $url = $post->content->getUrl(false, true);
                    $result[] = array($url);
                    echo $url . "\n";
                }
            }
        }
        $this->writeCsv($from . 'to' . $to, $result);
    }

    public function actionStrong()
    {
        $patterns = array(
            '#\/community\/(?:\d+)\/forum\/(?:\w+)\/(\d+)\/$#',
            '#\/user\/(?:\d+)\/blog\/post(\d+)\/$#',
        );
        $result = array();

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

        $_result = array();
        foreach ($result as $path => $value) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $path, $matches) == 1) {
                    $id = $matches[1];
                    $post = \CommunityContent::model()->resetScope()->findByPk($id);

                    if ($post === null) {
                        echo $path . "\n";
                        continue;
                    }

                    if ($post->by_happy_giraffe == 0) {
                        unset($result[$path]);
                        continue;
                    }

                    $value['url'] = 'http://www.happy-giraffe.ru' . $path;
                    $value['title'] = $post->title;
                    $value['removed'] = $post->removed;
                    $value['diff'] = strtr($value['period1'] == 0 ? '-' : ($value['period2'] - $value['period1']) * 100 / $value['period1'], '.', ',');
                    $value['diffC'] = $value['period2'] - $value['period1'];

                    $text = $post->getContent()->text;
                    if ($dom = str_get_html($text)) {
                        $value['strong'] = count($dom->find('strong'));
                        $value['em'] = count($dom->find('em'));
                    } else {
                        $value['strong'] = 0;
                        $value['em'] = 0;
                    }

                    $_result[] = $value;
                }
            }
        }

        $path = Yii::getPathOfAlias('site.frontend.www-submodule') . DIRECTORY_SEPARATOR . '1807.csv';
        if (is_file($path)) {
            unlink($path);
        }
        $fp = fopen($path, 'w');

        foreach ($_result as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }

    public function actionFuckedUpHoroscope()
    {
        Yii::import('site.frontend.modules.services.modules.horoscope.models.*');

        $sql = "
            SELECT COUNT(*) AS c, zodiac, date
            FROM services__horoscope
            WHERE date != '0000-00-00' AND date IS NOT NULL
            GROUP BY date
            HAVING c != 12
        ";

        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        $result = array();
        foreach ($rows as $r) {
            $horoscopes = Horoscope::model()->findAllByAttributes(array(
                'date' => $r['date'],
            ), array(
                'index' => 'zodiac',
            ));
            foreach (Horoscope::model()->zodiac_list as $zodiac => $title) {
                if (! array_key_exists($zodiac, $horoscopes)) {
                    $result[] = array(
                        $r['date'],
                        $title,
                    );
                }
            }
        }

        $path = Yii::getPathOfAlias('site.frontend.www-submodule') . DIRECTORY_SEPARATOR . 'lol.csv';
        if (is_file($path)) {
            unlink($path);
        }
        $fp = fopen($path, 'w');

        foreach ($result as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }

    protected function writeCsv($name, $data)
    {
        $path = Yii::getPathOfAlias('site.frontend.www-submodule') . DIRECTORY_SEPARATOR . $name . '.csv';
        if (is_file($path)) {
            unlink($path);
        }
        $fp = fopen($path, 'w');

        foreach ($data as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }
} 