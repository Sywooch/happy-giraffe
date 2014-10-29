<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 17/07/14
 * Time: 16:54
 */

namespace site\frontend\modules\photo\controllers;


use site\frontend\modules\notifications\models\User;
use site\frontend\modules\photo\components\observers\PhotoCollectionIdsObserver;
use site\frontend\modules\photo\components\PhotoController;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\upload\PopupForm;

class DefaultController extends PhotoController
{
    public function actionPresets()
    {
        echo \CJSON::encode(\Yii::app()->thumbs->presets);
    }

    public function actionIndex($userId)
    {
        $user = \User::model()->findByPk($userId);
        if ($user === null) {
            throw new \CHttpException(404);
        }

        $this->render('index', compact('userId', 'user'));
    }

    public function actionCreate($userId)
    {
        $json = compact('userId');
        $this->render('create', compact('json'));
    }

    public function actionAlbum($userId, $id)
    {
        $album = PhotoAlbum::model()->user($userId)->findByPk($id);
        if ($album === null) {
            throw new \CHttpException(404);
        }

        $this->render('album', compact('userId', 'id', 'album'));
    }

    /**
     * Выводит попап загрузки фото
     */
    public function actionUploadForm()
    {
        $form = new PopupForm();
        $form->attributes = $_GET;
        $form->userId = \Yii::app()->user->id;
        if ($form->validate()) {
            $this->renderPartial('upload/form', compact('form'));
        }
    }
} 