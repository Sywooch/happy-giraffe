<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 18/09/14
 * Time: 12:32
 */

namespace site\frontend\modules\photo\controllers\api;
use site\frontend\modules\photo\models\PhotoAlbum;

class AlbumsController extends \site\frontend\components\api\ApiController
{
    public function actionUserAlbums()
    {
        echo 123;
        die;
        $userId = \Yii::app()->request->getPost('userId');
        $albums = PhotoAlbum::model()->user($userId)->findAll();
        $this->success = true;
        $this->data = \HJSON::encode($albums);
    }
} 