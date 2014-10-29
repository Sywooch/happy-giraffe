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
    public function actionGet($id)
    {
        $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $id);
        $this->success = true;
        $this->data = $collection;
    }

    public function actionListAttaches($collectionId, $page, $pageSize)
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

    public function actionGetByUser($userId)
    {
        /** @var \User $user */
        $user = $this->getModel('\User', $userId);
        $this->success = true;
        $this->data = array(
            'all' => $user->getPhotoCollection('default'),
            'unsorted' => $user->getPhotoCollection('unsorted'),
        );
    }

    public function actionSetCover($collectionId, $attachId)
    {
        /** @var \site\frontend\modules\photo\models\PhotoCollection $collection */
        $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $collectionId, 'setCover');
        $attach = $this->getModel('site\frontend\modules\photo\models\PhotoAttach', $attachId);
        $this->success = $collection->setCover($attach) && $collection->save(true, array('cover_id'));
    }

    public function actionAddPhotos($collectionId, array $photosIds)
    {
        /** @var \site\frontend\modules\photo\models\PhotoCollection $collection */
        $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $collectionId, 'addPhotos');
        $this->success = $collection->attachPhotos($photosIds);
    }

    public function actionSortAttaches($collectionId, array $attachesIds)
    {
        /** @var \site\frontend\modules\photo\models\PhotoCollection $collection */
        $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $collectionId, 'sortPhotoCollection');
        $collection->sortAttaches($attachesIds);
        $this->success = true;
    }

    public function actionMoveAttaches($sourceCollectionId, $destinationCollectionId, array $attachesIds)
    {
        /** @var \site\frontend\modules\photo\models\PhotoCollection $collection */
        $collection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $sourceCollectionId, 'moveAttaches');
        $destinationCollection = $this->getModel('site\frontend\modules\photo\models\PhotoCollection', $destinationCollectionId, 'moveAttaches');
        $this->success = $collection->moveAttaches($destinationCollection, $attachesIds);
    }
} 