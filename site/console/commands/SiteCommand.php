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

    public function actionRemoveOldNotifications()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.common.models.mongo.*');

        $criteria = new EMongoCriteria();
        $criteria->created('<', strtotime('-1 month'));
        UserNotification::model()->deleteAll($criteria);
    }

    public function actionFix2()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.modules.cook.models.*');
        Yii::import('site.common.models.mongo.*');

        $users = Yii::app()->db->createCommand()->select('id')->from('users')->where('`group` = 6')->queryColumn();
        foreach ($users as $user) {
            $criteria = new EMongoCriteria();
            $criteria->type = UserAction::USER_ACTION_COMMENT_ADDED;
            $criteria->user_id = (int)$user;

            $actions = UserAction::model()->findAll($criteria);
            echo count($actions) . "\n";
            foreach ($actions as $action) {
                $comment = Comment::model()->findByPk($action->data['id']);
                if ($comment !== null) {
                    $model = CActiveRecord::model($comment->entity)->findByPk($comment->entity_id);
                    if (empty($model->rubric_id)) {
                        $action->delete();
                        echo "+\n";
                    }
                }
            }
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
                'clubs_ids'=>array(
                    'equals' => 37
                )
            ),
        ));

        $models = FriendEventClubs::model(FriendEvent::TYPE_CLUBS_JOINED)->findAll($criteria);
        echo count($models)."\n";

        foreach($models as $model){
            if (count($model->clubs_ids) == 1)
                $model->delete();
            else{
                foreach($model->clubs_ids as $key=>$club_id){
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

    public function actionFixImages(){
        Yii::import('site.frontend.components.*');
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;
        $criteria->condition = 'content_id > 20000 AND content_id < 40000';

        $models = array(0);
        while (!empty($models)) {
            $models = CommunityPost::model()->findAll($criteria);

            foreach ($models as $model) {
                if (strpos($model->text, '<img') !== false){
                    echo $model->content_id."\n";
                    $model->save();
                }
            }

            $criteria->offset += 100;
        }
    }
}