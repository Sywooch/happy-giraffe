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
            'robots.txt - ' . ($robotsResult ? 'OK' : 'BROKEN') . "\n" .
                'sitemap.xml - ' . ($sitemapResult ? 'OK' : 'BROKEN') . "\n";

        if (!($robotsResult && $sitemapResult)) {
            mail(implode(', ', $this->recipients), 'happy-giraffe.ru seo check failure', $output);
        }
    }

    public $moderators = array(23, 83, 10023, 10264, 10064);
    public $smo = array(12998, 13093, 13130, 13094, 13217);
    public $editors = array(10379, 10378, 10265, 12949, 10385, 10384, 13361, 13107, 12950, 13096,
        13235, 13122, 10433, 13002, 13105, 13099, 12411, 13101, 13103, 13098, 10358, 13136, 10359, 13137, 10391);

    public function actionSendCard($photo_id)
    {
        $users = Yii::app()->db->createCommand()
            ->select('id')
            ->from('users')
            ->where('deleted = 0 AND blocked = 0')
            ->queryAll();

        foreach ($users as $u) {
            $comment = new Comment('giraffe');
            $comment->author_id = 1;
            $comment->entity = 'User';
            $comment->entity_id = $u['id'];
            $comment->save();

            $attach = new AttachPhoto;
            $attach->photo_id = $photo_id;
            $attach->entity = 'Comment';
            $attach->entity_id = $comment->id;
            $attach->save();
        }
    }

    public function actionGeneratePreviews()
    {
        Yii::import('site.frontend.extensions.image.Image');
        Yii::import('site.frontend.extensions.helpers.CArray');

        $limit = 1000;
        $offset = 0;
        $i = 0;

        while ($photos = AlbumPhoto::model()->active()->findAll(array('order' => 'id DESC', 'limit' => $limit, 'offset' => $offset))) {
            foreach ($photos as $p) {
                echo ++$i . ':' . $p->getPreviewUrl(960, 627, Image::HEIGHT) . "\n";
            }
            $offset += $limit;
        }
    }

    public function actionHoroscope()
    {
        Yii::import('site.frontend.modules.services.modules.horoscope.models.*');
        $models = Horoscope::model()->findAll('date IS NOT NULL');
        foreach ($models as $model) {
            $m = new HoroscopeLink();
            $m->generateLinks($model);
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

    public function actionFixImages()
    {
        Yii::import('site.frontend.components.*');
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;
        $criteria->condition = 'content_id > 39052 AND content_id < 40000';

        $models = array(0);
        while (!empty($models)) {
            $models = CommunityPost::model()->findAll($criteria);

            foreach ($models as $model) {
                if (strpos($model->text, '<img') !== false) {
                    echo $model->content_id . "\n";
                    $model->save();
                }
            }

            $criteria->offset += 100;
        }
    }

    public function actionFixPreviews()
    {
        Yii::import('site.frontend.components.*');
        $last_id = 39000;
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->condition = 't.id > ' . $last_id . ' AND t.type_id = 1';
        $criteria->order = 't.id';

        $models = array(0);
        while (!empty($models)) {
            $models = CommunityContent::model()->with(array('post'))->findAll($criteria);

            foreach ($models as $model) {
                if (strpos($model->preview, '<img') !== false) {
                    echo $model->id . "\n";
                    $model->purify($model->post->text);
                }
                $last_id = $model->id;
            }

            $criteria->condition = 't.id > ' . $last_id . ' AND t.type_id = 1';
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

    public function actionStats(){
        Yii::import('site.frontend.modules.friends.models.*');
        $criteria = new CDbCriteria;
        $criteria->condition = 'last_updated >= "'.date("Y-m-d H:i:s", strtotime('-1 year')).'" and deleted = 0 AND `group`=0';
        $criteria->group = 'id';
        $criteria->limit = 100;
        $criteria->order = 'last_updated desc';
        $criteria->offset = 0;

        $result = array();
        $models = 1;
        $fp = fopen('/home/beryllium/file.csv', 'w');
        while(!empty($models)){
            $models = User::model()->findAll($criteria);

            foreach($models as $model){
                $posts_count = CommunityContent::model()->count('author_id=:author_id and removed = 0', array(':author_id' => $model->id));
                $comments_count = Comment::model()->count('author_id=:author_id and removed = 0 and entity != "ContestWork"', array(':author_id' => $model->id));

                if ($comments_count > 0){
                    $result = array(
                        $model->getFullName(),
                        'http://www.happy-giraffe.ru/user/'.$model->id.'/',
                        $model->register_date,
                        $model->last_updated,
                        $model->last_updated,
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
}