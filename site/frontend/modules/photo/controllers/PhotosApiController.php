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
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoCrop;
use site\frontend\modules\photo\models\upload\ByUrlUploadForm;
use site\frontend\modules\photo\models\upload\FromComputerUploadForm;

class PhotosApiController extends ApiController
{

    public function actionUpdate($photoId, $url = false, $title = false, $description = false)
    {
        /** @var \site\frontend\modules\photo\models\Photo $photo */
        $photo = $this->getModel('site\frontend\modules\photo\models\Photo', $photoId, 'editPhoto');
        if ($url !== false) {
            $photo->image = file_get_contents($url);
        }
        if ($title !== false) {
            $photo->title = htmlspecialchars($title);
        }
        if ($description !== false) {
            $photo->description = htmlspecialchars($description);
        }
        $this->success = $photo->save();
        $this->data = $photo;
    }

    public function actionUploadFromComputer($collectionId = null)
    {
        if (!\Yii::app()->user->checkAccess('uploadPhoto')) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $form = new FromComputerUploadForm($this->getCollection($collectionId));
        $form->file = \CUploadedFile::getInstanceByName('image');
        $this->success = $form->save();
        $this->data = $form;
    }

    public function actionUploadByUrl($url, $collectionId = null)
    {
        if (!\Yii::app()->user->checkAccess('uploadPhoto')) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $form = new ByUrlUploadForm($this->getCollection($collectionId));
        $form->url = $url;
        $this->success = $form->save();
        $this->data = $form;
    }

    public function actionPresets()
    {
        $data = \Yii::app()->thumbs->presets;
        foreach ($data as &$preset) {
            $preset['hash'] = \Yii::app()->thumbs->hash($preset['filter']);
        }
        $this->success = true;
        $this->data = $data;
    }

    protected function getCollection($collectionId)
    {
        if ($collectionId !== null) {
            //$collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $collectionId, 'addPhotos');
            $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $collectionId, false);
        } else {
            $collection = null;
        }
        return $collection;
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

    /**
     * @todo workaround для того, чтобы работал экшн uploadFromComputer, получающий запрос от jquery file upload
     */
    public function getActionParams()
    {
        if (!empty($_POST)) {
            return $_POST;
        } else {
            return parent::getActionParams();
        }
    }

}