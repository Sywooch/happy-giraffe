<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 23/09/14
 * Time: 16:40
 */

namespace site\frontend\modules\photo\controllers;


use site\frontend\components\api\ApiController;
use site\frontend\modules\photo\models\PhotoModify;
use site\frontend\modules\photo\models\upload\ByUrlUploadForm;

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