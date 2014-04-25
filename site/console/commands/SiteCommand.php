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

    /**
     * Запускается в 00:01 каждый день
     */
    public function actionStartDay()
    {
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

        //обновляет просмотры гороскопа и популных постов
        UserAttributes::removeAttr('popular_posts_count');
        UserAttributes::removeAttr('horoscope_seen');
        UserAttributes::removeAttr('popular_hide');

        //обновляем просмотры
        $dataProvider = new CActiveDataProvider('CommunityContent', array('criteria' => array('order' => 'id asc')));
        $iterator = new CDataProviderIterator($dataProvider, 1000);
        foreach ($iterator as $content) {
            $views = PageView::model()->viewsByPath($content->getUrl());
            if ($views && $views != $content->views) {
                Yii::app()->db->createCommand()->update('community__contents', array('views' => $views), 'id=' . $content->id);
            }
            if ($content->id % 1000 == 0)
                echo $content->id . "\n";
        }
    }

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
            'robots.txt - ' . ($robotsResult ? 'OK' : 'BROKEN') . "\n" .
            'sitemap.xml - ' . ($sitemapResult ? 'OK' : 'BROKEN') . "\n";

        if (!($robotsResult && $sitemapResult)) {
            mail(implode(', ', $this->recipients), 'happy-giraffe.ru seo check failure', $output);
        }
    }

    public function actionFixClubEvents()
    {
        Yii::import('site.frontend.modules.whatsNew.models.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

        FriendEventClubs::model(FriendEvent::TYPE_CLUBS_JOINED);
        $criteria = new EMongoCriteria(array(
            'conditions' => array(
                'type' => array(
                    'equals' => FriendEvent::TYPE_CLUBS_JOINED,
                ),
                'clubs_ids' => array(
                    'equals' => 37
                )
            ),
        ));

        $models = FriendEventClubs::model(FriendEvent::TYPE_CLUBS_JOINED)->findAll($criteria);
        echo count($models) . "\n";

        foreach ($models as $model) {
            if (count($model->clubs_ids) == 1)
                $model->delete();
            else {
                foreach ($model->clubs_ids as $key => $club_id) {
                    if ($club_id == 37)
                        unset($model->clubs_ids[$key]);
                }
                $model->save();
            }
        }
    }

    public function actionFixFriendEvents()
    {
        Yii::import('site.frontend.modules.whatsNew.models.*');
        Yii::import('site.frontend.modules.cook.models.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

        echo "remove articles\n";
        $criteria = new CDbCriteria;
        $criteria->limit = 500;
        $criteria->offset = 0;
        $criteria->condition = 'removed = 1';

        $models = 1;
        while (!empty($models)) {
            $models = CommunityContent::model()->resetScope()->findAll($criteria);
            echo count($models) . "\n";
            foreach ($models as $model) {
                FriendEvent::postDeleted(($model->isFromBlog ? 'BlogContent' : 'CommunityContent'), $model->id);
            }

            $criteria->offset += 1000;
        }

        echo "remove recipes\n";
        $models = CookRecipe::model()->resetScope()->findAll('removed = 1');
        echo count($models) . "\n";
        foreach ($models as $model)
            FriendEvent::postDeleted('CookRecipe', $model->id);

        echo "remove users\n";
        $criteria = new CDbCriteria;
        $criteria->limit = 500;
        $criteria->offset = 0;
        $criteria->condition = 'deleted = 1';

        $models = 1;
        while (!empty($models)) {
            $models = User::model()->resetScope()->findAll($criteria);
            echo count($models) . "\n";
            foreach ($models as $model) {
                FriendEvent::userDeleted($model);
            }

            $criteria->offset += 1000;
        }
    }

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

    public function actionStats()
    {
        Yii::import('site.frontend.modules.friends.models.*');
        $criteria = new CDbCriteria;
        $criteria->condition = 'last_active >= "' . date("Y-m-d H:i:s", strtotime('-3 month')) . '" and deleted = 0 AND `group`=0';
        $criteria->limit = 100;
        $criteria->order = 'last_active desc';
        $criteria->offset = 0;

        $models = 1;
        $fp = fopen('/home/beryllium/file.csv', 'w');
        while (!empty($models)) {
            $models = User::model()->findAll($criteria);

            foreach ($models as $model) {
                $posts_count = CommunityContent::model()->count('author_id=:author_id and removed = 0 and created > :last_month',
                    array(':author_id' => $model->id, ':last_month' => date("Y-m-d H:i:s", strtotime('-3 month'))));
                $comments_count = Comment::model()->count('author_id=:author_id and removed = 0 and entity != "ContestWork" and created > :last_month',
                    array(':author_id' => $model->id, ':last_month' => date("Y-m-d H:i:s", strtotime('-3 month'))));

                if ($comments_count > 0 && $posts_count > 0) {
                    $result = array(
                        $model->getFullName(),
                        'http://www.happy-giraffe.ru/user/' . $model->id . '/',
                        date("Y-m-d", strtotime($model->register_date)),
                        date("Y-m-d", strtotime($model->last_active)),
                        $posts_count,
                        $comments_count,
                        Friend::model()->getCountByUserId($model->id)
                    );
                    fputcsv($fp, $result);
                }
            }

            $criteria->offset = $criteria->offset + 100;
        }
    }

    /**
     * Запуск каждый час
     */
    public function actionCounter()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.*');
        $se_visits = GApi::model()->visitors('/', '2012-04-12', date("Y-m-d"));
        echo $se_visits . "\n";
        UserAttributes::set(1, 'all_visitors_count', $se_visits);
    }

    public function actionFlushSchemaCache()
    {
        Yii::app()->db->schema->getTables();
        Yii::app()->db->schema->refresh();
        Yii::app()->clearGlobalState(ClientScript::RELEASE_ID_KEY);
    }

    public function actionCleanJsd()
    {
        $path = Yii::getPathOfAlias('site.frontend.www-submodule.jsd') . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . '*';
        echo $path;
        $files = glob($path); // get all file names
        print_r($files);
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
        }
    }
}