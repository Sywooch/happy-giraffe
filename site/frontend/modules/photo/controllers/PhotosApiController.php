<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 23/09/14
 * Time: 16:40
 */

namespace site\frontend\modules\photo\controllers;


use site\frontend\components\api\ApiController;
use site\frontend\modules\photo\components\thumbs\ImageDecorator;
use site\frontend\modules\photo\helpers\ImageSizeHelper;
use site\frontend\modules\photo\models\PhotoModify;
use site\frontend\modules\photo\models\upload\ByUrlUploadForm;
use site\frontend\modules\photo\models\upload\FromComputerUploadForm;

class PhotosApiController extends ApiController
{
    public function actionUpdate($url, $photoId)
    {
        $photo = $this->getModel('site\frontend\modules\photo\models\Photo', $photoId);
        $imageString = file_get_contents($url);
        $photo->setImage($imageString);
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

    public function actionRotate($angle, $photoId)
    {
        $photo = $this->getModel('site\frontend\modules\photo\models\Photo', $photoId);
        $decorator = new ImageDecorator($photo->image, true);
        $decorator->rotate($angle);
        $photo->image = $decorator->get();
        $this->success = $photo->save();
        if ($this->success) {
            $this->data = $photo;
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