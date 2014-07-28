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
    protected function getPathes($start, $end, $searchEngine = null)
    {
        $ga = new GoogleAnalytics('nikita@happy-giraffe.ru', 'ummvxhwmqzkrpgzj');
        $ga->setProfile('ga:53688414');

        $cacheId = 'Yii.seo.paths.' . $start . '.' . $end . '.' . $searchEngine;
        $paths = Yii::app()->cache->get($cacheId);
        if ($paths === false) {
            $ga->setDateRange($start, $end);
            $properties = array(
                'metrics' => 'ga:entrances',
                'dimensions' => 'ga:pagePath',
                'max-results' => 10000,
                'sort' => '-ga:entrances',
            );
            if ($searchEngine !== null) {
                $properties['filters'] = 'ga:source=@' . $searchEngine;
            }
            $paths = $ga->getReport($properties);
            Yii::app()->cache->set($cacheId, $paths);
        }
        return $paths;
    }

    public function actionBadContent($type)
    {
        $result = array();

        $paths1 = $this->getPathes('2014-05-18', '2014-05-18', 'google');
        $paths2 = $this->getPathes('2014-05-18', '2014-05-18', 'yandex');
        $paths3 = $this->getPathes('2014-06-16', '2014-06-16', 'google');
        $paths4 = $this->getPathes('2014-06-16', '2014-06-16', 'yandex');

        $paths = array($paths1, $paths2, $paths3, $paths4);

        foreach ($paths as $k => $p) {
            foreach ($p as $path => $value) {
                if (! isset($result[$path])) {
                    $result[$path] = array_fill(0, 4, 0);
                }
                $result[$path][$k] = $value['ga:sessions'];
            }
        }

        $_result = array();
        foreach ($result as $path => $counts) {
            switch ($type) {
                case 'users':
                        if (preg_match('#^\/user\/(\d+)\/$#', $path, $matches)) {
                            $id = $matches[1];
                            $contentCount = CommunityContent::model()->count('type_id IN (5,6) AND author_id = :id', array(':id' => $id));
                            $_result[] = array_merge(array(
                                'http://www.happy-giraffe.ru' . $path,
                                $contentCount,
                            ), $counts);
                        }
                    break;
                case 'reposts':
                case 'statuses':
                    $t = $type == 'reposts' ? CommunityContent::TYPE_REPOST : CommunityContent::TYPE_STATUS;

                    $patterns = array(
                        '#\/community\/(?:\d+)\/forum\/(?:\w+)\/(\d+)\/$#',
                        '#\/user\/(?:\d+)\/blog\/post(\d+)\/$#',
                    );

                    foreach ($patterns as $pattern) {
                        if (preg_match($pattern, $path, $matches)) {
                            $id = $matches[1];

                            $post = CommunityContent::model()->resetScope()->findByPk($id);

                            if ($post === null) {
                                echo $path . "\n";
                                continue;
                            }

                            if ($post->type_id == $t) {
                                $_result[] = array_merge(array(
                                    'http://www.happy-giraffe.ru' . $path,
                                ), $counts);
                            }
                        }
                    }
                    break;
            }
        }

        $this->writeCsv($type, $_result);
    }

    public function actionEnters()
    {
        $patterns = array(
            '#\/community\/(?:\d+)\/forum\/(?:\w+)\/(\d+)\/$#',
            '#\/user\/(?:\d+)\/blog\/post(\d+)\/$#',
        );

        $result = array();
        $paths = $this->getPathes('2014-04-27', '2014-07-28');
        foreach ($paths as $path => $value) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $path, $matches)) {
                    $id = $matches[1];
                    $post = CommunityContent::model()->resetScope()->findByPk($id);

                    if ($post === null) {
                        echo $path . "\n";
                        continue;
                    }

                    $result[] = array('http://www.happy-giraffe.ru' . $path, $post->title, $value['ga:entrances']);
                }
            }
        }

        $this->writeCsv('enters', $result);
    }

    public function actionRoutesTest()
    {
        Yii::import('site.frontend.modules.routes.models.*');

        $models = Yii::app()->db->createCommand()
            ->select('id')
            ->from(Route::model()->tableName())
            ->where('wordstat_value >= '.Route::WORDSTAT_LIMIT)
            ->where(array('in', 'status', array(Route::STATUS_ROSNEFT_FOUND, Route::STATUS_GOOGLE_PARSE_SUCCESS)))
            ->queryColumn();

        echo count($models);
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
                'condition' => 'content.removed = 0',
            ),
        ));
        $iterator = new CDataProviderIterator($dp, 1000);
        foreach ($iterator as $post) {
            if ($dom = str_get_html($post->text)) {
                $els = $dom->find($from);
                if (count($els) > 0) {
                    foreach ($els as $el) {
                        $el->outertext = '<' . $to . '>' . $el->innertext . '</' . $to . '>';
                    }
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

        $paths = $this->getPathes('2014-05-19', '2014-05-19', 'google');
        foreach ($paths as $path => $value) {
            $result[$path] = array(
                'period1' => $value['ga:sessions'],
                'period2' => 0,
            );
        }

        $paths = $this->getPathes('2014-06-16', '2014-06-16', 'google');
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
                        $value['b'] = count($dom->find('b'));
                    } else {
                        $value['b'] = 0;
                    }

                    $_result[] = $value;
                }
            }
        }

        $this->writeCsv('b', $_result);
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

    public function actionDuplicateComments()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.modules.notifications.components.*');
        Yii::import('site.frontend.modules.notifications.models.*');
        Yii::import('site.frontend.modules.notifications.models.base.*');
        Yii::import('site.frontend.modules.scores.components.*');
        Yii::import('site.frontend.modules.scores.components.awards.*');
        Yii::import('site.frontend.modules.scores.models.*');
        Yii::import('site.frontend.modules.scores.models.input.*');

        $result = array();

        $dp = new CActiveDataProvider('CommunityContent', array(
            'criteria' => array(
                'order' => 't.id ASC',
                'with' => 'comments',
            ),
        ));
        $iterator = new CDataProviderIterator($dp, 100);
        $this->duplicateHelper($iterator, $result);

        $dp = new CActiveDataProvider('BlogContent', array(
            'criteria' => array(
                'order' => 't.id ASC',
                'with' => 'comments',
            ),
        ));
        $iterator = new CDataProviderIterator($dp, 100);
        $this->duplicateHelper($iterator, $result);

        $this->writeCsv('duplicates', $result);
    }

    protected function duplicateHelper($iterator, &$result)
    {
        foreach ($iterator as $post) {
            echo $post->id . "\n";
            $comments = $post->comments;
            $count = count($comments);
            foreach ($comments as $i => $comment) {
                for ($j = ($i + 1); $j < $count; $j++) {
                    if ($comment->text == $comments[$j]->text && $comment->author_id == $comments[$j]->author_id) {
                        $result[] = array($post->getUrl(false, true), $post->id, $comment->id, $comments[$j]->id);
                        $comment->delete();
                        break;
                    }
                }
            }
        }
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