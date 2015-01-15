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
use site\frontend\modules\users\components\AvatarManager;
use site\frontend\modules\users\models\User;

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
        $user = User::model()->findByPk(12936);
        $photo = Photo::model()->findByPk(140);

        $cropData = array(
            'x' => 250,
            'y' => 250,
            'w' => 100,
            'h' => 100,
        );
        AvatarManager::setAvatar($user, $photo, $cropData);
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