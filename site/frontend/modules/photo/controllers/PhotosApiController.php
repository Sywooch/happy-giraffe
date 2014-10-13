<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 23/09/14
 * Time: 16:40
 */

namespace site\frontend\modules\photo\controllers;


use site\frontend\components\api\ApiController;
use site\frontend\modules\photo\components\InlinePhotoModifier;
use site\frontend\modules\photo\components\thumbs\ImageDecorator;
use site\frontend\modules\photo\helpers\ImageSizeHelper;
use site\frontend\modules\photo\models\PhotoModify;
use site\frontend\modules\photo\models\upload\ByUrlUploadForm;
use site\frontend\modules\photo\models\upload\FromComputerUploadForm;

class PhotosApiController extends ApiController
{
    public function actionUpdate($url, $photoId)
    {
        /** @var \site\frontend\modules\photo\models\Photo $photo */
        $photo = $this->getModel('site\frontend\modules\photo\models\Photo', $photoId, 'editPhoto');
        $photo->image = file_get_contents($url);
        $this->success = $photo->save();
        $this->data = $photo;
    }

    public function actionUploadFromComputer()
    {
        if (! \Yii::app()->user->checkAccess('uploadPhoto')) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $form = new FromComputerUploadForm();
        $form->file = \CUploadedFile::getInstanceByName('image');
        $this->success = $form->save();
        $this->data = $form;
    }

    public function actionUploadByUrl($url)
    {
        if (! \Yii::app()->user->checkAccess('uploadPhoto')) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $form = new ByUrlUploadForm();
        $form->url = $url;
        $this->success = $form->save();
        $this->data = $form;
    }

    public function actionRotate($photoId, $clockwise = true)
    {
        $photo = $this->getModel('site\frontend\modules\photo\models\Photo', $photoId, 'editPhoto');
        $angle = $clockwise ? 90 : -90;
        $result = InlinePhotoModifier::rotate($photo, $angle);
        $this->success = $result !== false;
        if ($this->success) {
            $this->data = $result;
        }
    }

//    public function actionMakeAvatar($photoId, array $cropData)
//    {
//        $photo = $this->getModel('site\frontend\modules\photo\models\Photo', $photoId);
//
//        \Yii::app()
//
//        $crop = new \PhotoCrop();
//        $crop->attributes = $cropData;
//        $crop->photo_id = $photoId;
//        $crop->save();
//    }
} 