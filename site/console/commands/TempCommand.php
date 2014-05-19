<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 9/26/13
 * Time: 7:43 PM
 * To change this template use File | Settings | File Templates.
 */

class TempCommand extends CConsoleCommand
{
    public function actionCheatViews($url, $perDay, $days)
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.PageView');
        $start = time();
        while (time() < ($start + $days * 24 * 60 * 60)) {
            $sleep = 24 * 60 * 60 / $perDay / 2;
            PageView::model()->cheat($url, 0, 1);
            sleep($sleep);
        }
    }

    public function actionCheatPampers()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.PageView');
        while (true) {
            PageView::model()->cheat('/community/10/forum/post/101319/', 0, 1);
            sleep(60);
        }
    }

    public function actionBabies()
    {
        $dp = new CActiveDataProvider('Baby');
        $iterator = new CDataProviderIterator($dp, 1000);
        foreach ($iterator as $baby)
            $baby->save(false);
    }

    public function actionClearblue($date1, $date2)
    {
        $views = GApi::model()->pageViews('/test/pregnancy/', $date1, $date2);
        $uniqueVisitors = GApi::model()->uniquePageViews('/test/pregnancy/', $date1, $date2);
        echo 'Views: ' . $views . "\n";
        echo 'Unique visitors: ' . $uniqueVisitors . "\n";
    }

    public function actionAddProxy()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.seo.models.mongo.*');

        $a = array (
            '46.165.200.102:701',
            '46.165.200.104:701',
            '95.211.156.222:701',
            '95.211.189.193:701',
            '95.211.189.194:701',
            '95.211.189.197:701',
            '46.165.200.108:701',
            '46.165.200.117:701',
            '46.165.200.118:701',
            '95.211.159.77:701',
            '5.79.80.216:701',
            '95.211.199.9:701',
            '5.79.86.212:701',
            '5.79.86.213:701',
            '5.79.86.205:701',
            '5.79.86.206:701',
            '95.211.231.133:701',
            '95.211.195.161:701',
        );

        foreach ($a as $proxy)
            ProxyMongo::model()->addNewProxy($proxy);
    }

    public function actionLikes($date1, $date2)
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.HGLike');
        echo HGLike::model()->DateLikes($date1, $date2);
    }

    public function actionVicks()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.UserAttributes');
        Yii::import('site.frontend.modules.messaging.models.*');
        $lastUserId = UserAttributes::get(1, 'lastUser', 0);
        $criteria = new CDbCriteria();
        $criteria->condition = 'id > :lastUserId AND blocked = 0 AND deleted = 0';
        $criteria->params = array(':lastUserId' => $lastUserId);
        $criteria->limit = 1000;
        $criteria->order = 'id ASC';
        $users = User::model()->findAll($criteria);
        $text = 'Весёлый Жираф рекомендует Vicks:<a href="http://ad.adriver.ru/cgi-bin/click.cgi?sid=1&bt=21&ad=420520&pid=1315141&bid=2835794&bn=2835794&rnd=' . mt_rand(100000000, 999999999) . '" onclick="_gaq.push([\'_trackEvent\',\'Outgoing Links\',\'www.vicks.ru\'])"><br><br><img src="http://banners.adfox.ru/131101/adfox/309734/551.jpg" alt="Vicks"></a>';

        foreach ($users as $u) {
            $thread = MessagingThread::model()->findOrCreate(1, $u->id);
            MessagingMessage::model()->create($text, $thread->id, 1, array(), true);
        }

        UserAttributes::set(1, 'lastUser', end($users)->id);
    }

    public function actionVicksTest()
    {
        Yii::import('site.frontend.modules.messaging.models.*');
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', array(12936, 56, 16534));
        $users = User::model()->findAll($criteria);
        $text = 'Весёлый Жираф рекомендует Vicks:<a href="http://ad.adriver.ru/cgi-bin/click.cgi?sid=1&bt=21&ad=420520&pid=1314853&bid=2835781&bn=2835781&rnd=%random%" onclick="_gaq.push([\'_trackEvent\',\'Outgoing Links\',\'www.vicks.ru\'])"><br><br><img src="http://banners.adfox.ru/131101/adfox/309734/551.jpg" alt="Vicks"></a>';

        foreach ($users as $u) {
            $thread = MessagingThread::model()->findOrCreate(1, $u->id);
            MessagingMessage::model()->create($text, $thread->id, 1, array(), true);
        }
    }

    public function actionCopyScape()
    {
        $criteria = new CDbCriteria();
        $criteria->with = array('author', 'post');
        $criteria->condition = 't.id > 112549 AND uniqueness IS NULL AND type_id = 1 AND (author.group = 0 OR author.group = 4)';

        $dp = new CActiveDataProvider('CommunityContent', array(
            'criteria' => $criteria,
        ));

        $iterator = new CDataProviderIterator($dp);
        $count = $dp->totalItemCount;
        $i = 0;
        foreach ($iterator as $post) {
            $i++;
            $post->uniqueness = (strlen($post->post->text) > 250) ? CopyScape::getUniquenessByText($post->post->text) : 1;
            $post->update(array('uniqueness'));
            echo $i . '/' . $count . "\n";
        }
    }

    public function actionSeo1()
    {
        $criteria = new CDbCriteria();
        $criteria->with = array('post');
        $criteria->condition = 'uniqueness IS NULL AND type_id = 1';
        $criteria->addInCondition('author_id', array(181638, 34531));

        $dp = new CActiveDataProvider('CommunityContent', array(
            'criteria' => $criteria,
        ));

        $iterator = new CDataProviderIterator($dp);
        $count = $dp->totalItemCount;
        $i = 0;
        foreach ($iterator as $post) {
            $i++;
            $post->uniqueness = (strlen($post->post->text) > 250) ? CopyScape::getUniquenessByText($post->post->text) : 1;
            $post->update(array('uniqueness'));
            echo $i . '/' . $count . "\n";
        }
    }

    public function actionSeo2()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.extensions.GoogleAnalytics');

        $ga = new GoogleAnalytics('nikita@happy-giraffe.ru', 'ummvxhwmqzkrpgzj');
        $ga->setProfile('ga:53688414');
        $ga->setDateRange('2013-09-01', '2013-12-24');

        $criteria = new CDbCriteria();
        $criteria->addInCondition('author_id', array(181638, 34531));
        $criteria->order = 'id ASC';

        $dp = new CActiveDataProvider('CommunityContent', array(
            'criteria' => $criteria,
        ));

        $iterator = new CDataProviderIterator($dp);
        $count = $dp->totalItemCount;
        $i = 0;
        foreach ($iterator as $post) {
            $i++;

            if (Seo2::model()->findByAttributes(array('url' => $post->url)) === null) {
                do {
                    $report = null;
                    try {
                        $report = $ga->getReport(array(
                            'metrics' => 'ga:uniquePageviews',
                            'sort' => '-ga:uniquePageviews',
                            'dimensions' => 'ga:source',
                            'filters' => urlencode('ga:pagePath==' . $post->url),
                        ));
                    } catch(Exception $e) {
                        sleep(300);
                        echo "waiting...\n";
                    }
                } while ($report === null);

                $google = isset($report['google']) ? $report['google']['ga:uniquePageviews'] : 0;
                $yandex = isset($report['yandex']) ? $report['yandex']['ga:uniquePageviews'] : 0;
                $model = new Seo2();
                $model->url = $post->url;
                $model->google = $google;
                $model->yandex = $yandex;
                $model->save();
            }

            echo $i . '/' . $count . "\n";
        }
    }

    public function actionSeo3()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.extensions.GoogleAnalytics');

        $ga = new GoogleAnalytics('nikita@happy-giraffe.ru', 'ummvxhwmqzkrpgzj');
        $ga->setProfile('ga:53688414');
        $ga->setDateRange('2013-01-01', '2013-12-24');

        $criteria = new CDbCriteria();
        $criteria->compare('removed', 1);
        $criteria->order = 'id ASC';

        $dp = new CActiveDataProvider(CommunityContent::model()->resetScope(), array(
            'criteria' => $criteria,
        ));

        $iterator = new CDataProviderIterator($dp);
        $count = $dp->totalItemCount;
        $i = 0;
        foreach ($iterator as $post) {
            $i++;

            if (Seo3::model()->findByAttributes(array('url' => $post->url)) === null) {
                do {
                    $report = null;
                    try {
                        $report = $ga->getReport(array(
                            'metrics' => 'ga:uniquePageviews',
                            'sort' => '-ga:uniquePageviews',
                            'dimensions' => 'ga:source',
                            'filters' => urlencode('ga:pagePath==' . $post->url),
                        ));
                    } catch(Exception $e) {
                        sleep(300);
                        echo "waiting...\n";
                    }
                } while ($report === null);

                $google = isset($report['google']) ? $report['google']['ga:uniquePageviews'] : 0;
                $yandex = isset($report['yandex']) ? $report['yandex']['ga:uniquePageviews'] : 0;
                $model = new Seo3();
                $model->url = $post->url;
                $model->google = $google;
                $model->yandex = $yandex;
                $model->save();
            }

            echo $i . '/' . $count . "\n";
        }
    }

    public function actionModerStats()
    {
        $moders = array(
//            159841,
//            175718,
//            15426,
//            189230,
//            167771,
//            15994,
            15814,
        );
        sort($moders);
        $dateFrom = '2014-04-01';
        $dateTo = '2014-05-01';

        $commentsCounts = Yii::app()->db->createCommand()
            ->select('author_id, DATE(created) AS d, COUNT(*) AS c')
            ->from('comments')
            ->where(array('in', 'author_id'))
            ->andWhere('removed = 0')
            ->andWhere('DATE(created) BETWEEN :dateFrom AND :dateTo', array(':dateFrom' => $dateFrom, ':dateTo' => $dateTo))
            ->group('author_id, d')
            ->queryAll();

        $postsCounts = Yii::app()->db->createCommand()
            ->select('author_id, DATE(created) AS d, COUNT(*) AS c')
            ->from('community__contents')
            ->where(array('in', 'author_id'))
            ->andWhere('removed = 0')
            ->andWhere('DATE(created) BETWEEN :dateFrom AND :dateTo', array(':dateFrom' => $dateFrom, ':dateTo' => $dateTo))
            ->group('author_id, d')
            ->queryAll();

        $photosCounts = Yii::app()->db->createCommand()
            ->select('author_id, DATE(created) AS d, COUNT(*) AS c')
            ->from('album__photos')
            ->where(array('in', 'author_id'))
            ->andWhere('removed = 0')
            ->andWhere('DATE(created) BETWEEN :dateFrom AND :dateTo', array(':dateFrom' => $dateFrom, ':dateTo' => $dateTo))
            ->group('author_id, d')
            ->queryAll();

        $messagesCounts = Yii::app()->db->createCommand()
            ->select('author_id, DATE(created) AS d, COUNT(*) AS c')
            ->from('messaging__messages')
            ->where(array('in', 'author_id'))
            ->andWhere('DATE(created) BETWEEN :dateFrom AND :dateTo', array(':dateFrom' => $dateFrom, ':dateTo' => $dateTo))
            ->group('author_id, d')
            ->queryAll();

        $sources = array($commentsCounts, $postsCounts, $messagesCounts, $photosCounts);

        $from = new DateTime($dateFrom);
        $to = new DateTime($dateTo);
        $period = new DatePeriod($from, new DateInterval('P1D'), $to);

        $data = array();

        foreach ($sources as $source) {
            $titleRow = array('');
            foreach ($period as $dt) {
                $date = $dt->format('Y-m-d');
                $titleRow[] = $date;
            }
            $data[] = $titleRow;

            foreach ($moders as $moder) {
                $dataRow = array();
                $dataRow[] = 'http://www.happy-giraffe.ru/user/' . $moder . '/';
                foreach ($period as $dt) {
                    $date = $dt->format('Y-m-d');

                    $count = 0;
                    foreach ($source as $row) {
                        if ($row['author_id'] == $moder && $row['d'] == $date) {
                            $count = $row['c'];
                        }
                    }

                    $dataRow[] = $count;
                }
                $data[] = $dataRow;
            }
        }

        $fp = fopen(Yii::getPathOfAlias('site.frontend.www-submodule') . DIRECTORY_SEPARATOR . 'stats.csv', 'w');
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
    }
}