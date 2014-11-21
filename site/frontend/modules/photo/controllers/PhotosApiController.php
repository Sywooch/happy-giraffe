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

    public function actionUploadFromComputer($collectionId = null)
    {
        if (! \Yii::app()->user->checkAccess('uploadPhoto')) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $form = new FromComputerUploadForm($this->getCollection($collectionId));
        $form->file = \CUploadedFile::getInstanceByName('image');
        $this->success = $form->save();
        $this->data = $form;
    }

    public function actionUploadByUrl($url, $collectionId = null)
    {
        if (! \Yii::app()->user->checkAccess('uploadPhoto')) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $form = new ByUrlUploadForm($this->getCollection($collectionId));
        $form->url = $url;
        $this->success = $form->save();
        $this->data = $form;
    }

    protected function getCollection($collectionId)
    {
        if ($collectionId !== null) {
            $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $collectionId, 'addPhotos');
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
        if (! empty($_POST)) {
            return $_POST;
        } else {
            return parent::getActionParams();
        }
    }
} 