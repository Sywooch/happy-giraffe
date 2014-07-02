<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 02/07/14
 * Time: 14:29
 */

namespace site\frontend\modules\photo\commands;


use site\frontend\modules\photo\models\Photo;

class DefaultCommand extends \CConsoleCommand
{
    public function actionThumbsWorker()
    {
        \Yii::app()->gearman->worker()->addFunction('createThumbs', function($photoId) {
            $photo = Photo::model()->findByPk($photoId);
            \Yii::app()->getModule('photo')->thumbs->createAll($photo);
        });
    }
} 