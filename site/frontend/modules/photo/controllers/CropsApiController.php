<?php
/**
 * @author Никита
 * @date 25/12/14
 */

namespace site\frontend\modules\photo\controllers;

use site\frontend\components\api\ApiController;
use site\frontend\modules\photo\models\PhotoCrop;

class CropsApiController extends ApiController
{
    public function actionGet($id)
    {
        $crop = $this->getModel('site\frontend\modules\photo\models\PhotoCrop', $id);
        $this->success = $crop !== null;
        $this->data = $crop;
    }

    public function actionCreate($photoId, array $cropData)
    {
        $photo = $this->getModel('site\frontend\modules\photo\models\Photo', $photoId);
        $crop = PhotoCrop::create($photo, $cropData);
        $this->success = $crop->save();
        $this->data = $crop;
    }

    public function actionRemove($id)
    {
        $crop = $this->getModel('site\frontend\modules\photo\models\PhotoCrop', $id);
        $this->success = $crop->delete();
    }
} 