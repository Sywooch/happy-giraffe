<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 17/07/14
 * Time: 16:54
 */

namespace site\frontend\modules\photo\controllers;


use site\frontend\modules\photo\components\observers\PhotoCollectionIdsObserver;
use site\frontend\modules\photo\components\PhotoController;
use site\frontend\modules\photo\models\PhotoAlbum;

class DefaultController extends PhotoController
{
    public function actionPresets()
    {
        echo \CJSON::encode(\Yii::app()->thumbs->presets);
    }

    public function actionIndex($userId)
    {
        $albums = PhotoAlbum::model()->user($userId)->findAll();
        foreach ($albums as $album) {
            $album->photoCollection = $album->getCollection('all');
            $obs = new PhotoCollectionIdsObserver($album->photoCollection);
            $album->photoCollection->attaches = $obs->getSlice(5, -5);
        }
        $json = \HJSON::encode(array('albums' => $albums));
        $this->render('index', compact('json'));
    }
} 