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
        $thumb = \Yii::app()->thumbs->getThumbByUrl($url);
        $thumb->show();
    }
} 