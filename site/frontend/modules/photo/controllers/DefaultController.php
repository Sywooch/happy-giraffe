<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 17/07/14
 * Time: 16:54
 */

namespace site\frontend\modules\photo\controllers;
use site\frontend\modules\photo\components\PhotoController;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\upload\PopupForm;

class DefaultController extends PhotoController
{
    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
                'actions' => array('create', 'uploadForm'),
            ),
        );
    }

    public function filters()
    {
        return array(
            'showMenu - single',
        );
    }

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
        if ($userId !== \Yii::app()->user->id) {
            throw new \CHttpException(404);
        }
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

    public function actionSingle($userId, $albumId, $photoId)
    {
        /** @var \site\frontend\modules\photo\models\PhotoAlbum $album */
        $album = PhotoAlbum::model()->findByPk($albumId);
        if ($album === null || $album->getAuthorId() != $userId) {
            throw new \CHttpException(404);
        }
        $collection = $album->getPhotoCollection();
        $attach = PhotoAttach::model()->collection($collection->id)->photo($photoId)->with('photo')->find();
        if ($attach === null) {
            throw new \CHttpException(404);
        }
        $currentIndex = $collection->observer->getIndexByAttachId($attach->id);
        $nextAttach = $collection->observer->getSingle($currentIndex + 1);
        $prevAttach = $collection->observer->getSingle($currentIndex - 1);
        $this->render('single', compact('attach', 'userId', 'album'));
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