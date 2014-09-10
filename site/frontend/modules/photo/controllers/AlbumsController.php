<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 07/07/14
 * Time: 15:28
 */

namespace site\frontend\modules\photo\controllers;
use site\frontend\modules\photo\components\PhotoController;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoCollection;

class AlbumsController extends PhotoController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionCreate()
    {
        $model = new PhotoAlbum();

        $this->performAjaxValidation($model);

        if (isset($_POST['PhotoAlbum'])) {
            $model->attributes = $_POST['PhotoAlbum'];
            $model->save();
        }

        $this->pageTitle = 'Создание альбома';
        $this->render('create', compact('model'));
    }

    public function actionView($albumId)
    {

    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'createAlbumForm')
        {
            echo \CActiveForm::validate($model);
            \Yii::app()->end();
        }
    }

//    public function actionCreate()
//    {
//        $album = new PhotoAlbum();
//        $album->attributes = $_POST;
//        $album->author_id = \Yii::app()->user->id;
//        $album->save();
//
//        $photoCollection = new PhotoCollection();
//        $photoCollection->entity_id = $album->id;
//        $photoCollection->entity = 'PhotoAlbum';
//        $photoCollection->save();
//
//        echo \HJSON::encode($album, array(
//            'site\frontend\modules\photo\models\PhotoAlbum' => array(
//                'id',
//                'title',
//                'description',
//                'photoCollection' => array(
//                    'site\frontend\modules\photo\models\PhotoCollection' => array(
//                        'id',
//                        '(int)attachesCount',
//                        'cover',
//                    ),
//                ),
//            ),
//        ));
//    }
} 