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
    protected $ga;
    protected $patterns = array(
        '#\/community\/(?:\d+)\/forum\/(?:\w+)\/(\d+)\/$#',
        '#\/user\/(?:\d+)\/blog\/post(\d+)\/$#',
    );

    public function init()
    {
        $this->ga = new GoogleAnalytics('nikita@happy-giraffe.ru', 'ummvxhwmqzkrpgzj');
        $this->ga->setProfile('ga:53688414');
    }

    protected function getPathes($start, $end, $searchEngine = null)
    {
        $cacheId = 'Yii.seo.paths.' . $start . '.' . $end . '.' . $searchEngine;
        $paths = Yii::app()->cache->get($cacheId);
        if ($paths === false) {
            $this->ga->setDateRange($start, $end);
            $properties = array(
                'metrics' => 'ga:entrances',
                'dimensions' => 'ga:pagePath',
                'max-results' => 10000,
                'sort' => '-ga:entrances',
            );
            if ($searchEngine !== null) {
                $properties['filters'] = 'ga:source=@' . $searchEngine;
            }
            $paths = $this->ga->getReport($properties);
            Yii::app()->cache->set($cacheId, $paths);
        }
        return $paths;
    }

    public function actionDumb($file)
    {
        $result = array();

        $handle = fopen("$file", "r");

        $j = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $inserts = array();
            foreach ($data as $k => $v) {
                if (strpos($v, 'http://') === 0) {
                    $dumbData = $this->dumbSingle($v);
                    $inserts[$k] = $dumbData;
                }
            }

            $i = 0;
            foreach ($inserts as $k => $v) {
                array_splice($data, $k + $i * 7, 0, $v);
                $i++;
            }
            $result[] = $data;
            $j++;

            if ($j > 3) {
                break;
            }
        }
        fclose($handle);


        $this->writeCsv('test', $result);
    }

    protected function dumbSingle($url)
    {
        $path = str_replace('http://www.happy-giraffe.ru', '', $url);

        $post = $this->getPostByPath($path);

        $googleSummer = $this->dumbSummer($path, 'google');
        $yandexSummer = $this->dumbSummer($path, 'yandex');
        $googleTotal = $this->dumbTotal($path, 'google');
        $yandexTotal = $this->dumbTotal($path, 'yandex');
        $yandexKeywords = $this->dumbKeywords($path, 'yandex');
        $googleKeywords = $this->dumbKeywords($path, 'google');

        return array(
            $post === null ? '-' : $post->created,
            $yandexTotal,
            $googleTotal,
            $yandexSummer,
            $googleSummer,
            $yandexKeywords,
            $googleKeywords,
        );
    }

    protected function dumbTotal($path, $engine)
    {
        $this->ga->setDateRange('2005-01-01', '2014-08-13');
        $report = $this->ga->getReport(array(
            'metrics' => 'ga:entrances',
            'filters' => 'ga:source=@' . $engine . ';ga:pagePath==' . urlencode($path),
        ));

        return isset($report['']['ga:entrances']) ? $report['']['ga:entrances'] : 0;
    }

    protected function dumbSummer($path, $engine)
    {
        $this->ga->setDateRange('2014-06-01', '2014-07-31');
        $report = $this->ga->getReport(array(
            'metrics' => 'ga:entrances',
            'filters' => 'ga:source=@' . $engine . ';ga:pagePath==' . urlencode($path),
        ));

        return isset($report['']['ga:entrances']) ? $report['']['ga:entrances'] : 0;
    }

    protected function dumbKeywords($path, $engine)
    {
        $keywords = '';

        $this->ga->setDateRange('2005-01-01', '2014-08-13');
        $report = $this->ga->getReport(array(
            'dimensions' => 'ga:keyword',
            'metrics' => 'ga:entrances',
            'filters' => 'ga:source=@' . $engine . ';ga:pagePath==' . urlencode($path),
        ));

        foreach ($report as $keyword => $value) {
            $n += $value['ga:entrances'];
            $keywords .= $keyword . ' - ' . $value['ga:entrances'] . "\n";
        }

        return $keywords;
    }

    protected function getPostByPath($path)
    {
        foreach ($this->patterns as $p) {
            if (preg_match($p, $path, $matches)) {
                $id = $matches[1];
                $post = CommunityContent::model()->findByPk($id);
                return $post;
            }
        }
        return null;
    }

    public function actionEpicFail()
    {
        $patterns = array(
            '#\/community\/(?:\d+)\/forum\/(?:\w+)\/(\d+)\/$#',
            '#\/user\/(?:\d+)\/blog\/post(\d+)\/$#',
        );

        $result = array();

        $paths1 = $this->getPathes('2014-06-26', '2014-06-26', 'yandex');
        $paths2 = $this->getPathes('2014-07-03', '2014-07-03', 'yandex');

        $paths = array($paths1, $paths2);

        foreach ($paths as $k => $p) {
            foreach ($p as $path => $value) {
                if (! isset($result[$path])) {
                    $result[$path] = array_fill(0, 2, 0);
                }
                $result[$path][$k] = $value['ga:entrances'];
            }
        }

        $_result = array();
        foreach ($result as $path => $counts) {
            $_result[$path] = array(
                'period1' => $counts[0],
                'period2' => $counts[1],
                'diff' => $counts[1] - $counts[0],
            );
        }

        $diffs = array();
        foreach ($_result as $k => $v) {
            $diffs[$k] = $v['diff'];
        }

        array_multisort($diffs, SORT_ASC, $_result);

        $__result = array();

        foreach ($_result as $path => $value) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $path, $matches)) {
                    $id = $matches[1];

                    $post = CommunityContent::model()->resetScope()->findByPk($id);

                    if ($post === null) {
                        continue;
                    }

                    $__result[] = array(
                        $post->title,
                        'http://www.happy-giraffe.ru' . $path,
                        $value['period1'],
                        $value['period2'],
                        $value['diff'],
                    );
                }
            }
            if (count($__result) == 100) {
                break;
            }
        }

        $this->writeCsv('epicFail', $__result);
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

                    $result[] = array('http://www.happy-giraffe.ru' . $path, $post->title, $value['ga:entrances'], $post->commentsCount);
                }
            }
        }

        $this->writeCsv('enters', $result);
    }

    public function actionSitemapCounts()
    {
        $models = Yii::app()->db->createCommand()
            ->select('id')
            ->from(CookRecipeTag::model()->tableName())
            ->queryAll();

        echo count($models);
    }

    public function actionRoutesTest()
    {
        Yii::import('site.frontend.modules.routes.models.*');

        $models = Yii::app()->db->createCommand()
            ->select('id')
            ->from(Route::model()->tableName())
            ->where(array('and', 'wordstat_value >= '.Route::WORDSTAT_LIMIT, array('in', 'status', array(Route::STATUS_ROSNEFT_FOUND, Route::STATUS_GOOGLE_PARSE_SUCCESS))))
            ->queryColumn();

        echo count($models) . "\n";

        $models = Yii::app()->db->createCommand()
            ->select('id')
            ->from(Route::model()->tableName())
            ->where('wordstat_value >= '.Route::WORDSTAT_LIMIT)
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

    public function actionDelReposts()
    {
        $result = array();
        $reposts = CommunityContent::model()->resetScope()->findAllByAttributes(array('type_id' => CommunityContent::TYPE_REPOST));
        foreach ($reposts as $r) {
            $result[] = array($r->getUrl(false, true));
        }
        $this->writeCsv('delReposts', $result);
    }

    public function actionSiteMap()
    {
        Yii::import('site.frontend.modules.cook.models.*');

        $result = array();
        $rubrics = CommunityRubric::model()->findAll('community_id IS NOT NULL');
        foreach ($rubrics as $r) {
            $result[] = array($r->title, 'http://www.happy-giraffe.ru' . $r->getUrl());
        }
        $this->writeCsv('rubrics', $result);

        $result = array();
        $rubrics = CookRecipeTag::model()->findAll();
        foreach ($rubrics as $r) {
            $result[] = array($r->title, 'http://www.happy-giraffe.ru' . $r->getUrl());
        }
        $this->writeCsv('tags', $result);
    }

    public function actionFindHeaders()
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');

        $dp = new CActiveDataProvider('RecipeBookRecipe');
        $iterator = new CDataProviderIterator($dp, 1000);
        foreach ($iterator as $recipe) {
            $dom = str_get_html($recipe->text);
            if (count($dom->find('h1')) > 0) {
                echo $recipe->getUrl(false, true) . "\n";
            }
        }
    }

    public function actionTitles()
    {
        Yii::import('site.frontend.modules.cook.models.*');
        $pattern = '#[^\.][\.]$#';

        $result = array();

        $dp = new CActiveDataProvider('CommunityContent');
        $iterator = new CDataProviderIterator($dp, 1000);
        foreach ($iterator as $data) {
            if (preg_match($pattern, rtrim($data->title))) {
                $result[] = array($data->title, $data->getUrl(false, true));
            }
        }

        $dp = new CActiveDataProvider('CookRecipe');
        $iterator = new CDataProviderIterator($dp, 1000);
        foreach ($iterator as $data) {
            if (preg_match($pattern, rtrim($data->title))) {
                $result[] = array($data->title, $data->getUrl(false, true));
            }
        }

        $this->writeCsv('titles', $result);
    }

    public function actionRecipeBook()
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');

        $result = array();

        $categories = RecipeBookDiseaseCategory::model()->with('diseases')->findAll(array('order' => 't.title ASC, diseases.title ASC'));
        foreach ($categories as $category) {
            $result[] = array($category->title, '');
            foreach ($category->diseases as $disease) {
                $result[] = array('', $disease->title);
            }
        }

        $this->writeCsv('recipeBook', $result);
    }

    public function actionShort()
    {
        $result = array();

        $dp = new CActiveDataProvider('CommunityContent', array(
            'criteria' => array(
                'condition' => 'type_id = :type',
                'params' => array(':type' => CommunityContent::TYPE_POST),
            ),
        ));
        $iterator = new CDataProviderIterator($dp, 1000);
        foreach ($iterator as $post) {
            $length = strlen(strip_tags($post->content->text));
            $uniqueness = $post->uniqueness === null ? '-' : $post->uniqueness;
            $result[] = array($post->title, $post->getUrl(false, true), $length, $uniqueness);
        }
        $this->writeCsv('short', $result);
    }

    public function actionRecipeBookData()
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');

        $result = array();

        $categories = RecipeBookDiseaseCategory::model()->findAll();
        foreach ($categories as $category) {
            $result[] = array(
                'http://www.happy-giraffe.ru' . $category->getUrl(),
                $category->title,
                $category->title . ' | ' . implode(', ', array_map(function($disease) {
                    return $disease->title;
                }, $category->diseases)),
                'Народные рецепты. ' . $category->title,
                strip_tags($category->description),
                $category->id,
            );
        }

        $this->writeCsv('category', $result);

        $result = array();

        $diseases = RecipeBookDisease::model()->findAll();
        foreach ($diseases as $disease) {
            $result[] = array(
                'http://www.happy-giraffe.ru' . $disease->getUrl(),
                $disease->title,
                strip_tags($disease->title . ' | ' . $disease->text),
                'Народные рецепты. ' . $disease->title,
                strip_tags($disease->text),
                $disease->id,
            );
        }

        $this->writeCsv('disease', $result);
    }
} 