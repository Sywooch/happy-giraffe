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

    protected function getReport($params)
    {
        $report = null;
        while ($report === null) {
            try {
                $report = $this->ga->getReport($params);
            } catch (Exception $e) {
                echo $e->getMessage() . "\n";
                echo "waiting...\n";
                sleep(10);
            }
        }
        return $report;
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

    public function actionComments($id)
    {
        $comment = \site\frontend\modules\comments\models\Comment::model()->findByPk($id);
        $comment->save();
    }

    public function actionSpec()
    {
        $a = array(
//            //260 => 1, //Новости медицины
//            261 => 433659, //Народная медицина
//            262 => 433649, //Симптомы и ощущения
//            263 => 433654, //Лекарственные препараты и витамины
//            264 => 433659, //Анализы и обследования
//            //265 => 1, //Больницы, клиники, центры
//            266 => 433684, //Аллерголог (аллергические заболевания)
//            267 => 433689, //Андролог (заболевания мужской половой сферы)
//            268 => 433829, //Венеролог (заболевания, передающиеся половым путем)
//            269 => 433839, //Гастроэнтеролог (заболевания желудочно-кишечного тракта)
//            270 => 433894, //Гематолог (заболевания крови)
//            271 => 433904, //Генетик (генетические патологии)
//            272 => 433649, //Гепатолог (заболевания печени)
//            273 => 433909, //Гинеколог (заболевания женской половой сферы)
//            274 => 433829, //Дерматолог (заболевания кожи)
//            275 => 433684, //Иммунолог (проблемы иммунитета)
//            276 => 433839, //Инфекционист (инфекционные заболевания)
//            277 => 433974, //Кардиолог (заболевания сердца)
//            278 => 433979, //Нарколог (проблемы зависимостей)
//            279 => 433984, //Невропатолог (заболевания нервной системы)
//            280 => 433989, //Нефролог (заболевания почек)
//            281 => 433994, //Онколог (онкологические заболевания (опухоли))
//            282 => 433999, //Ортопед (проблемы опорно-двигательного аппарата)
//            283 => 434004, //Отоларинголог (проблемы уха, горла, носа)
//            284 => 434009, //Офтальмолог (проблемы зрительного аппарата)
//            285 => 434014, //Проктолог (заболевания прямой кишки)
//            286 => 433979, //Психолог (психологическая помощь)
//            287 => 433979, //Психотерапевт (проблемы психики)
//            288 => 434019, //Пульмонолог (заболевания лёгких)
//            289 => 434024, //Ревматолог (ревматические заболевания)
//            290 => 434029, //Стоматолог (заболевания зубов и десен)
//            291 => 433649, //Терапевт (общие проблемы здоровья)
//            292 => 434034, //Токсиколог (лечение отравлений)
//            293 => 433999, //Травматолог (лечение травм)
//            294 => 433689, //Уролог (заболевания почек и мочевыводящих путей)
//            //295 => 1, //Фтизиатр (лечение туберкулеза)
//            296 => 433999, //Хирург (оперативное лечение)
            297 => 434039, //Эндокринолог (заболевания эндокринной системы)
//            2592 => 433649, //Диетолог
        );

        foreach ($a as $rubricId => $userId) {
            echo $rubricId . ":" . $userId . "\n";
            \site\common\components\temp\HgMove::move($rubricId, $userId);
        }
    }

    public function actionSpecUsers($club)
    {
        $file = Yii::getPathOfAlias('site.common.data') . DIRECTORY_SEPARATOR . $club . '.csv';

        $data = array();
        if (($handle = fopen($file, "r")) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                $data[] = $row;
            }
            fclose($handle);
        }

        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]); $j++) {
                if (preg_match('#Рубрика: (.*)#', $data[$i][$j], $matches)) {
                    $rubricName = $matches[1];
                    $rubric = CommunityRubric::model()->with('community')->find('t.title = :title AND community.club_id = :clubId', array(':title' => $rubricName, ':clubId' => $club));

                    $i2 = $i + 2;
                    $j2 = $j + 4;

                    if (preg_match('#\/user\/(\d+)\/#', $data[$i2][$j2], $matches2)) {
                        $userId = $matches2[1];
                        $title = $data[$i2 - 1][$j2 + 1];
                        $education = $data[$i2 - 1][$j2 + 2];
                        preg_match('#(\d+)#', $data[$i2 - 1][$j2 + 3], $m2);
                        $date = isset($m2[1]) ? $m2[1] : 15;

                        echo $rubricName . "\n";
                        echo $rubric->id . "\n";
                        echo $userId . "\n";
                        echo $title . "\n";
                        echo $education . "\n";
                        echo $date . "\n";
                        echo "\n";

//                        $user = \site\frontend\modules\users\models\User::model()->findByPk($userId);
//                        $user->specInfoObject->title = $title;
//                        $user->specInfoObject->education = $education;
//                        $user->register_date = '2012-01-' . $date . ' 00:00:00';
//                        $user->save();
                    } else {
                        echo "Не найден юзер - " . $matches2[0] . "\n";
                    }
                }


//                if (preg_match('#\/user\/(\d+)\/#', $data[$i][$j], $matches)) {
//                    $userId = $matches[1];
//                    $title = $data[$i - 1][$j + 1];
//                    $education = $data[$i - 1][$j + 2];
//                    preg_match('#(\d+)#', $data[$i - 1][$j + 3], $m2);
//                    $date = isset($m2[1]) ? $m2[1] : 15;
//
//                    $user = \site\frontend\modules\users\models\User::model()->findByPk($userId);
//                    $user->specInfoObject->title = $title;
//                    $user->specInfoObject->education = $education;
//                    $user->register_date = '2012-01-' . $date . ' 00:00:00';
//                    $user->save();
//                }
            }
        }
    }

    public function actionSpecTest()
    {
        $user = \site\frontend\modules\users\models\User::model()->findByPk(56);
        var_dump($user->specInfo);
    }

    public function actionRestore($a, $b)
    {
        \site\common\components\temp\HgMove::restore($a, $b);
    }

    public function actionHg($clubId)
    {
        $result = array();

        $club = CommunityClub::model()->findByPk($clubId);

        foreach ($club->communities as $forum) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('by_happy_giraffe = 1 OR author_id = 1');

            foreach ($forum->rubrics as $rubric) {
                $count = $rubric->getRelated('contentsCount', false, $criteria);

                if ($count == 0) {
                    continue;
                }

                $result[] = array('Рубрика: ' . $rubric->title, 'Постов в рубрике: ' . $count);

                $result[] = array('Заголовок', 'URL', 'Отметка 1', 'Отметка 2');
                foreach ($rubric->getRelated('contents', false, $criteria) as $c) {
                    $result[] = array($c->title, $c->getUrl(false, true), $c->by_happy_giraffe ? '+' : '-', ($c->author_id == User::HAPPY_GIRAFFE) ? '+' : '-');
                }
            }
        }

        $this->writeCsv('hg' . $clubId, $result);
    }

    public function actionUsers()
    {
        $result = array();
        $result[] = array('email', 'firstname', 'lastname');

        $dp = new CActiveDataProvider('User', array(
            'criteria' => array(
                'condition' => 'deleted = 0',
                'order' => 't.id ASC',
            ),
        ));
        $iterator = new CDataProviderIterator($dp, 1000);

        $j = 0;
        foreach ($iterator as $i => $u) {
            $result[] = array($u->email, $u->first_name, $u->last_name);
            echo $i . "\n";

            if ($i % 100000 == 0) {
                $this->writeCsv('users' . $j, $result);
                $result = array();
                $result[] = array('email', 'firstname', 'lastname');
                $j++;
            }
        }

        $this->writeCsv('users' . $j, $result);
    }

    public function actionParseMailRu()
    {
        $parser = new MailQuestionsParser();
        $parser->run();

        $this->writeCsv('questions', $parser->emails);
    }

    public function actionParseMailRu2()
    {
        $parser = new MailForumParser();
        $command = $this;
        $parser->run(function($emails) use ($command) {
            $result = array();
            foreach ($emails as $email) {
                $result[] = array($email);
            }
            $command->writeCsv('mailTopics2', $result);
        });
    }

    public function actionTraf()
    {
        $this->ga->setDateRange('2011-01-01', '2015-03-31');

        $result = array();
        $data = array();
        $page = 0;
        do {
            $page ++;
            $mr = 10000;
            $si = ($page - 1) * $mr + 1;
            $response = $this->getReport(array(
                'metrics' => 'ga:organicSearches',
                'dimensions' => 'ga:pagePath',
                'max-results' => $mr,
                'start-index' => $si,
            ));

            foreach ($response as $path => $row) {
                if ($row['ga:organicSearches'] > 1000) {
                    $data[$path] = array(
                        'http://www.happy-giraffe.ru' . $path,
                        $row['ga:organicSearches'],
                        0,
                    );
                }
            }

            echo "step1 $page\n";
        } while (count($response) > 0);

        echo count($data) . "\n";

        $this->ga->setDateRange('2015-04-01', '2015-04-14');

        $page = 0;
        do {
            $page ++;
            $mr = 10000;
            $si = ($page - 1) * $mr + 1;
            $response = $this->getReport(array(
                'metrics' => 'ga:organicSearches',
                'dimensions' => 'ga:pagePath',
                'max-results' => $mr,
                'start-index' => $si,
            ));

            foreach ($response as $path => $row) {
                if (isset($data[$path])) {
                    if ($row['ga:organicSearches'] < 50) {
                        $data[$path][2] = $row['ga:organicSearches'];
                    } else {
                        unset($data[$path]);
                    }
                }
            }
            echo "step2 $page\n";
        } while (count($response) > 0);

        usort($data, function($a, $b) {
            return $b[1] - $a[1];
        });

        $this->writeCsv('traf', $data);
    }

    public function actionCheckRemoved()
    {
        \Yii::import('site.frontend.widgets.userAvatarWidget.Avatar');
        \Yii::app()->db->enableSlave = false;
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
        $patterns = array(
            '^/community/\d+/forum/\w+/\d+/$',
            '^/user/\d+/blog/post\d+/$',
        );

        $dp = new CActiveDataProvider(\site\frontend\modules\posts\models\Content::model(), array(
            'criteria' => array(
                'condition' => 'isNoindex = 1 OR isRemoved = 1',
                'order' => 'id DESC',
            ),
        ));
        $iterator = new CDataProviderIterator($dp, 100);
        $this->ga->setDateRange('2011-01-01', date('Y-m-d'));

        $urlToCount = array();
        foreach ($patterns as $pattern) {
            $page = 0;
            do {
                $page++;
                $mr = 10000;
                $si = ($page - 1) * $mr + 1;
                $response = $this->getReport(array(
                    'metrics' => 'ga:organicSearches',
                    'dimensions' => 'ga:pagePath',
                    'filters' => 'ga:pagePath=~' . urlencode($pattern),
                    'max-results' => $mr,
                    'start-index' => $si,
                ));
                echo "response " . count($response) . "\n";
                foreach ($response as $path => $row) {
                    $urlToCount[$path] = $row['ga:organicSearches'];
                }
            } while (count($response) > 0);
        }


        echo count($urlToCount) . "\n";

        $result = array();
        foreach ($iterator as $i => $post) {

            $url = str_replace('http://www.happy-giraffe.ru', '', $post->url);
            if (isset($urlToCount[$url])) {
                $result[] = array(
                    $post->url,
                    $urlToCount[$url],
                    $post->isRemoved,
                    $post->isNoindex,
                    $post->user->fullName,
                    $post->uniqueIndex,
                );
            }
        }

        $this->writeCsv('checkRemoved', $result);
    }

    public function actionDumbTest()
    {
        $this->ga->setDateRange('2014-06-01', '2014-07-31');
        $result = $this->ga->getReport(array(
            'metrics' => 'ga:entrances',
            'filters' => 'ga:source=@yandex;ga:pagePath==' . urlencode('/community/24/forum/post/71710/'),
        ));

        var_dump($result);
    }

    public function actionDumb($file, $from, $to)
    {
        $result = array();

        $handle = fopen("$file", "r");

        $time = time();
        $j = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $j++;

            if ($j < $from) {
                continue;
            }

            $inserts = array();
            foreach ($data as $k => $v) {
                if (strpos($v, 'http://') === 0) {
                    $dumbData = $this->dumbSingle($v);
                    $inserts[$k] = $dumbData;
                }
            }

            $i = 0;
            foreach ($inserts as $k => $v) {
                array_splice($data, $k + 1 + $i * 7, 0, $v);
                $i++;
            }
            $result[] = $data;
            echo 'string ' . $j . ' - ' . (time() - $time) . "\n";

            if ($j == $to) {
                break;
            }

        }
        fclose($handle);


        $this->writeCsv('test', $result);
    }

    protected function dumbSingle($url)
    {
        $path = str_replace('http://www.happy-giraffe.ru', '', $url);

        //$post = $this->getPostByPath($path);

        $googleSummer = $this->dumbSummer($path, 'google');
        $yandexSummer = $this->dumbSummer($path, 'yandex');
        $googleTotal = $this->dumbTotal($path, 'google');
        $yandexTotal = $this->dumbTotal($path, 'yandex');
        $yandexKeywords = $this->dumbKeywords($path, 'yandex');
        $googleKeywords = $this->dumbKeywords($path, 'google');

        return array(
            '',
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
        $report = $this->getReport(array(
            'metrics' => 'ga:entrances',
            'filters' => 'ga:source=@' . $engine . ';ga:pagePath==' . urlencode($path),
        ));

        return isset($report['']['ga:entrances']) ? $report['']['ga:entrances'] : 0;
    }

    protected function dumbSummer($path, $engine)
    {
        $this->ga->setDateRange('2014-06-01', '2014-07-31');
        $report = $this->getReport(array(
            'metrics' => 'ga:entrances',
            'filters' => 'ga:source=@' . $engine . ';ga:pagePath==' . urlencode($path),
        ));

        return isset($report['']['ga:entrances']) ? $report['']['ga:entrances'] : 0;
    }

    protected function dumbKeywords($path, $engine)
    {
        $keywords = '';

        $this->ga->setDateRange('2005-01-01', '2014-08-13');
        $report = $this->getReport(array(
            'dimensions' => 'ga:keyword',
            'metrics' => 'ga:entrances',
            'filters' => 'ga:source=@' . $engine . ';ga:pagePath==' . urlencode($path),
        ));

        foreach ($report as $keyword => $value) {
            $keywords .= $keyword . ' - ' . $value['ga:entrances'] . "\n";
        }

        return $keywords;
    }

    protected function getPostByPath($path, $condition = '', $params = array())
    {
        foreach ($this->patterns as $p) {
            if (preg_match($p, $path, $matches)) {
                $id = $matches[1];
                $post = CommunityContent::model()->findByPk($id, $condition, $params);
                return $post;
            }
        }
        return null;
    }

    public function actionEpicfail2()
    {
        $result = array();

        $paths1 = $this->getPathes('2014-08-05', '2014-08-05', 'google');
        $paths2 = $this->getPathes('2014-08-12', '2014-08-12', 'google');

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
            if (($counts[1] - $counts[0]) < 0) {
                continue;
            }

            $post = $this->getPostByPath($path, array('with' => 'gallery'));

            if ($post === null) {
                $g = '-';
            } elseif ($post->gallery === null) {
                $g = 'N';
            } else {
                $g = 'Y';
            }

            $_result[] = array(
                'http://www.happy-giraffe.ru' . $path,
                $counts[0],
                $counts[1],
                $counts[1] - $counts[0],
                strtr($counts[0] == 0 ? '-' : ($counts[1] - $counts[0]) * 100 / $counts[0], '.', ','),
                $g,
            );
        }

        $this->writeCsv('epicFail2', $_result);
    }

    public function actionCompare($date1, $date2, $engine, $growth)
    {
        $result = array();

        $paths1 = $this->getPathes($date1, $date1, $engine);
        $paths2 = $this->getPathes($date2, $date2, $engine);

        $paths = array($paths1, $paths2);

        foreach ($paths as $k => $p) {
            foreach ($p as $path => $value) {
                if (! isset($result[$path])) {
                    $result[$path] = array_fill(0, 2, 0);
                }
                $result[$path][$k] = $value['ga:entrances'];
            }
        }

        $_result = array(array(
            'Ссылка',
            $date1,
            $date2,
            'Разница',
            'Разница, %',
            'Пост от ВЖ',
        ));
        foreach ($result as $path => $counts) {
            if ((($counts[1] - $counts[0]) > 0) != $growth) {
                continue;
            }

            $post = $this->getPostByPath($path);

            $_result[] = array(
                'http://www.happy-giraffe.ru' . $path,
                $counts[0],
                $counts[1],
                $counts[1] - $counts[0],
                strtr($counts[0] == 0 ? '-' : ($counts[1] - $counts[0]) * 100 / $counts[0], '.', ','),
                ($post === null) ? '-' : $post->by_happy_giraffe,
            );
        }

        $this->writeCsv('compare', $_result);
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

                    $post = CommunityContent::model()->resetScope()->with('gallery')->findByPk($id);

                    if ($post === null) {
                        continue;
                    }

                    $__result[] = array(
                        $post->title,
                        'http://www.happy-giraffe.ru' . $path,
                        $value['period1'],
                        $value['period2'],
                        $value['diff'],
                        $post->gallery === null ? 'N' : 'Y',
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

    public function writeCsv($name, $data)
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

    public function actionShevkoplyas()
    {
        $result = array();
        $posts = CommunityContent::model()->findAll('author_id = :author_id', array(':author_id' => 220231));
        foreach ($posts as $p) {
            $result[] = array($p->getUrl(false, true), $p->title);
        }
        $this->writeCsv('sh', $result);
    }

    public function actionLiRu($category, $nPages)
    {
        $urlBase = 'http://www.liveinternet.ru/rating/ru/' . $category . '/index.html';
        $client = new \Guzzle\Service\Client();
        $client->setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
        $result = array();
        $result[] = array('Название', 'Ссылка', 'Контакты');
        for ($i = 1; $i <= $nPages; $i++) {
            $url = $urlBase . '?page=' . $i;
            $html = $client->get($url)->send()->getBody(true);
            $doc = str_get_html($html);
            $links = $doc->find('a[onclick]');
            foreach ($links as $link) {
                $title = $link->innertext;
                $href = $link->href;
                $row = array($title, $href);
                $result[] = $row;
            }
            echo 'page ' . $i . ' finished' . "\n";
        }
        $this->writeCsv('li__' . $category, $result);
    }

    public function actionLiData()
    {
        Yii::import('site.seo.modules.competitors.components.*');
        Yii::import('site.seo.modules.competitors.models.*');
        $data = LiSitesManager::getData();
        $this->writeCsv('liData', $data);
    }

    public function actionEmails()
    {
        $path = Yii::getPathOfAlias('site.common.data') . DIRECTORY_SEPARATOR . 'vkladi3.csv';
        $emails = $this->emails($path);
        $_emails = array_map(function($email) {
            return array($email);
        }, $emails);
        $this->writeCsv('vkladi', $_emails);
    }

    protected function emails($path)
    {
        $pattern = "/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/";
        $handle = fopen($path, "r");
        $emails = array();
        while (($data = fgetcsv($handle)) !== false) {
            $num = count($data);
            for ($c = 0; $c < $num; $c++) {
                if (preg_match($pattern, $data[$c])) {
                    $emails[] = $data[$c];
                }
            }
        }
        return $emails;
    }
} 