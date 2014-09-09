<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 17/07/14
 * Time: 16:54
 */

namespace site\frontend\modules\photo\controllers;


use site\frontend\modules\photo\models\PhotoAlbum;

class DefaultController extends \HController
{
    public $layout = '//layouts/new/mainNew';

    public function actionPresets()
    {
        echo \CJSON::encode(\Yii::app()->thumbs->presets);
    }

    public function actionUser($userId = null)
    {
        $albums = PhotoAlbum::model()->user($userId)->findAll();
        $this->render('user');
    }
} 