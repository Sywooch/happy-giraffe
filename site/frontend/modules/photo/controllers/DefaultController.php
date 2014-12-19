<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 17/07/14
 * Time: 16:54
 */

namespace site\frontend\modules\photo\controllers;
use site\frontend\modules\photo\components\PhotoController;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\upload\PopupForm;

class DefaultController extends \LiteController
{
    public $litePackage = 'photo';

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
                'actions' => array('create', 'uploadForm'),
            ),
        );
    }

    public function actionPresets()
    {
        //header( 'Content-Type: image/jpeg' );
        $photo = Photo::model()->findByPk(250);
        $path = 'originals/' . $photo->fs_name;
        var_dump($photo->image);

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
        if ($userId !== \Yii::app()->user->id) {
            throw new \CHttpException(404);
        }
        $json = compact('userId');
        $this->render('create', compact('json'));
    }

    public function actionAlbum($userId, $id)
    {
        $album = PhotoAlbum::model()->user($userId)->with('author')->findByPk($id);
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