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

    public function actionFormRoutes()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.modules.services.modules.route.models.*');
        Yii::import('site.seo.models.*');

        $cities = GeoCity::model()->findAll('type="г"');
        echo count($cities);
        for ($i = 0; $i < count($cities); $i++){
            for ($j = 0; $j < count($cities); $j++)
                if ($cities[$i]->id != $cities[$j]->id) {
                    $model = new RouteParsing();
                    $model->city_from_id = $cities[$i]->id;
                    $model->city_to_id = $cities[$j]->id;
                    $model->save();
                }

            if ($i % 10 == 0)
            echo $i."\n";
        }
    }

    public function actionParseRoutes(){
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.modules.services.modules.route.models.*');
        Yii::import('site.seo.components.*');
        Yii::import('site.seo.models.*');

        $parser = new RouteParser;
        $parser->start(false);
    }
}