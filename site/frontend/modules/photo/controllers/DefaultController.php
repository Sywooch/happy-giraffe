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
use site\frontend\modules\photo\models\upload\PopupForm;

class DefaultController extends PhotoController
{
    public $layout = '//layouts/new/breadcrumbsNew';
    public function actionPresets()
    {
        echo \CJSON::encode(\Yii::app()->thumbs->presets);
    }

    public function actionIndex($userId)
    {
        $json = compact('userId');
        $this->render('index', compact('json'));
    }

    public function actionCreate($userId)
    {
        $json = compact('userId');
        $this->render('create', compact('json'));
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