<?php
/**
 * @author Никита
 * @date 31/10/14
 */

namespace site\frontend\modules\photo\controllers;


use site\frontend\modules\photo\models\Photo;

class TestController extends \HController
{
    public function actionCrop()
    {
        $photo = Photo::model()->findByPk(164);
        \Yii::app()->thumbs->getThumb($photo, 'test')->show();
    }
} 