<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 18/09/14
 * Time: 12:32
 */

namespace site\frontend\modules\photo\controllers;
use site\frontend\components\api\ApiController;
use site\frontend\modules\photo\models\PhotoAlbum;

class AlbumsApiController extends ApiController
{
    public function actionUserAlbums($userId)
    {
        $albums = PhotoAlbum::model()->user($userId)->findAll();
        $this->success = true;
        $this->data = \HJSON::encode($albums);
    }
} 