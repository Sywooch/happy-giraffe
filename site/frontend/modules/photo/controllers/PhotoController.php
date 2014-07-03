<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 02/07/14
 * Time: 14:33
 */

namespace site\frontend\modules\photo\controllers;


use site\frontend\modules\photo\models\Photo;

class PhotoController extends \HController
{
    public function actionThumb($url)
    {
        $array = explode('/', $url);
        $fsName = implode('/', array_slice($array, -3));
        $presetName = $array[count($array) - 4];
        $photo = Photo::model()->findByAttributes(array('fs_name' => $fsName));
        $thumb = \Yii::app()->thumbs->getThumb($photo, $presetName, true);
        $thumb->show();
    }
} 