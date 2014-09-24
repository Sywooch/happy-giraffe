<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 23/09/14
 * Time: 16:05
 */

namespace site\frontend\modules\photo\controllers;
use site\frontend\modules\photo\components\CollectionsManager;
use site\frontend\modules\photo\components\observers\PhotoCollectionObserver;
use site\frontend\modules\photo\models\collections\PhotoCollectionAbstract;
use site\frontend\modules\photo\models\PhotoCollection;
use site\frontend\modules\users\models\User;
use site\frontend\components\api\ApiController;

class CollectionsApiController extends ApiController
{
    public function actionGetAttaches($collectionId, $length, $offset)
    {
        $collection = $this->getCollection($collectionId);
        $observer = PhotoCollectionObserver::getObserver($collection);
        $this->success = true;
        $this->data = $observer->getSlice($length, $offset);
    }

    public function actionMy()
    {
        $user = User::model()->findByPk(\Yii::app()->user->id);
        if ($user === null) {
            throw new \CHttpException(404, 'Пользователь не найден');
        }
        $this->success = true;
        $this->data = $user->photoCollections;
    }

    public function actionAddPhotos($collectionId, array $photosIds)
    {
        $collection = $this->getCollection($collectionId);
        if (! \Yii::app()->user->checkAccess('addPhotos', compact('collection'))) {
            throw new \CException('Недостаточно прав');
        }
        $this->success = $collection->attachPhotos($photosIds);
    }

    public function actionSort($collectionId, $attachesIds)
    {
        $collection = $this->getCollection($collectionId);
        if (! \Yii::app()->user->checkAccess('sortPhotoCollection', compact('collection'))) {
            throw new \CException('Недостаточно прав');
        }
        $this->success = $collection->sort($attachesIds);
    }

    public function actionMove($sourceCollectionId, $destinationCollectionId, $attachesIds)
    {
        $this->success = CollectionsManager::moveAttaches($sourceCollectionId, $destinationCollectionId, $attachesIds);
    }

    /**
     * @param $collectionId
     * @return PhotoCollectionAbstract
     * @throws \CHttpException
     */
    protected function getCollection($collectionId)
    {
        /** @var PhotoCollectionAbstract $collection */
        $collection = PhotoCollection::model()->findByPk($collectionId);
        if ($collection === null) {
            throw new \CHttpException(404, 'Коллекция не найдена');
        }
        return $collection;
    }
} 