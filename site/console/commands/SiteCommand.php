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

    /**
     * mark all users with role
     */
    /*public function actionUserGroups()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->moderators);

        $users = User::model()->findAll($criteria);
        foreach ($users as $user) {
            $user->group = UserGroup::MODERATOR;
            $user->update(array('group'));
        }

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->smo);

        $users = User::model()->findAll($criteria);
        foreach ($users as $user) {
            $user->group = UserGroup::SMO;
            $user->update(array('group'));
        }

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->editors);

        $users = User::model()->findAll($criteria);
        foreach ($users as $user) {
            $user->group = UserGroup::EDITOR;
            $user->update(array('group'));
        }

        //virtuals
        $users = Yii::app()->db->createCommand('select distinct(userid) from auth__assignments where itemname="virtual_user"')->queryColumn();
        foreach ($users as $user_id) {
            $user = User::getUserById($user_id);
            $user->group = UserGroup::VIRTUAL;
            $user->update(array('group'));
        }
    }*/

    public function actionFormatDiseases()
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        Yii::import('site.frontend.helpers.*');

        $dizz = RecipeBookDisease::model()->findAll();
        foreach ($dizz as $diz) {

            $doc = phpQuery::newDocumentXHTML($diz->text, $charset = 'utf-8');
            //чистим атрибуты
            foreach (pq('h2, h3, p, strong, b, em, u, s, li') as $e) {
                pq($e)->removeAttr('style');
            }

            //убираем фонты
            foreach (pq('font') as $s) {
                pq($s)->replaceWith(pq($s)->html());
            }

            //убираем спаны
            while (count(pq('span')) > 0) {
                foreach (pq('span') as $s) {
                    pq($s)->replaceWith(pq($s)->html());
                }
            }

            //убираем em
            while (count(pq('em')) > 0) {
                foreach (pq('em') as $s) {
                    pq($s)->replaceWith(pq($s)->html());
                }
            }

            $diz->text = $doc;

            $image = $diz->getImage();
            if ($image !== false && !empty($image)) {
                $path = Yii::getPathOfAlias('site.frontend.www') . $image;
                if (file_exists($path)) {

                    $info = pathinfo($image);
                    $file_name = $info['basename'];
                    echo $file_name;

                    $dir = Yii::getPathOfAlias('site.common.uploads.photos.originals.') . DIRECTORY_SEPARATOR . '1';
                    if (!file_exists($dir))
                        mkdir($dir);

                    $new_path = $dir . DIRECTORY_SEPARATOR . $file_name;
                    if (!file_exists($new_path))
                        copy($path, $new_path);

                    $photo = new AlbumPhoto();
                    $photo->title = $diz->title;
                    $photo->author_id = 1;
                    $photo->file_name = $file_name;
                    $photo->fs_name = $file_name;
                    $photo->save();

                    $diz->photo_id = $photo->id;
                }
                //убираем фонты
                foreach (pq('img') as $s) {
                    pq($s)->replaceWith('');
                }
            }
            $diz->save();
        }
    }

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

    public function actionTest()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        $html = file_get_contents('http://ru.wikipedia.org/wiki/%D0%93%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%A3%D0%BA%D1%80%D0%B0%D0%B8%D0%BD%D1%8B');

        $document = phpQuery::newDocument($html);
        $k = 0;
        foreach ($document->find('#mw-content-text > ul > li') as $row) {
            $city_name = trim(pq($row)->find('a:first')->text());
            if ($city_name == 'Ямполь')
                continue;
            $region_name = trim(pq($row)->find('a:eq(1)')->text());

            if ($region_name == 'Автономная Республика Крым')
                $region_name = 'Республика Крым';
            if ($region_name == 'Ровненская область')
                $region_name = 'Республика Крым';
            //echo $city_name . ' - ' . $region_name . '<br>';

            $region = GeoRegion::model()->findByAttributes(array('country_id' => 221, 'name' => $region_name));
            if ($region === null)
                echo $region_name . ' not found<br>';
            else {
                $criteria = new CDbCriteria;
                $criteria->compare('country_id',221);
                $criteria->compare('region_id',$region->id);
                $criteria->compare('name',$city_name);
                $city = GeoCity::model()->find($criteria);

                if ($city === null){
                    $criteria = new CDbCriteria;
                    $criteria->compare('country_id',221);
                    $criteria->compare('region_id',$region->id);
                    $criteria->compare('name',$city_name, true);
                    $city = GeoCity::model()->find($criteria);
                    if ($city !== null){
                        echo $city_name.' - '.$city->name.'<br>';
                        $city->name = $city_name;
                        $city->save();
                    }

                    //echo $city_name . ' not found<br>';
                }
            }

            $k++;

            if ($k >= 414)
                break;
        }
    }
}