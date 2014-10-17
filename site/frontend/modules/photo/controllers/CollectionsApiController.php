<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 23/09/14
 * Time: 16:05
 */

namespace site\frontend\modules\photo\controllers;
use site\frontend\modules\photo\components\observers\PhotoCollectionObserver;
use site\frontend\components\api\ApiController;

class CollectionsApiController extends ApiController
{
    public function actionList($collectionId, $page, $pageSize)
    {
        $offset = $page * $pageSize;
        $length = $pageSize;

        $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $collectionId);
        $observer = PhotoCollectionObserver::getObserver($collection);
        $this->success = true;
        $this->data['attaches'] = $observer->getSlice($offset, $length, false);
        $this->data['isLast'] = ($offset + $length) >= $observer->getCount();
    }

    public function actionGetAttaches($collectionId, $offset, $length = null, $circular = false)
    {
        $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $collectionId);
        $observer = PhotoCollectionObserver::getObserver($collection);
        $this->success = true;
        $this->data['attaches'] = $observer->getSlice($offset, $length, $circular);
    }

    public function actionMy()
    {
        $user = $this->getModel('\User', \Yii::app()->user->id);
        $this->success = true;
        $this->data = $user->photoCollections;
    }

    public function actionSetCover($collectionId, $attachId)
    {
        $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $collectionId, 'setCover');
        $collection->setScenario('setCover');
        $this->success = $collection->setCover($attachId);
    }

    public function actionAddPhotos($collectionId, array $photosIds)
    {
        $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $collectionId, 'addPhotos');
        $this->success = $collection->attachPhotos($photosIds);
    }

    public function actionSortAttaches($collectionId, array $attachesIds)
    {
        $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $collectionId, 'sortPhotoCollection');
        $collection->sortAttaches($attachesIds);
        $this->success = true;
    }

    public function actionMoveAttaches($sourceCollectionId, $destinationCollectionId, array $attachesIds)
    {
        $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $sourceCollectionId, 'moveAttaches');
        $destinationCollection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $destinationCollectionId, 'moveAttaches');
        $this->success = $collection->moveAttaches($destinationCollection, $attachesIds);
    }

    /**
     * @param $class
     * @param $id
     * @param bool $checkAccess
     * @param bool $resetScope
     * @return \site\frontend\modules\photo\models\collections\PhotoCollectionAbstract
     */
    public function getModel($class, $id, $checkAccess = false, $resetScope = false)
    {
        return parent::getModel($class, $id, $checkAccess, $resetScope);
    }
} 