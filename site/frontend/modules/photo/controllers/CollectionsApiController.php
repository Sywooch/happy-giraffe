<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 23/09/14
 * Time: 16:05
 */

namespace site\frontend\modules\photo\controllers;
use site\frontend\modules\photo\components\CollectionsManager;
use site\frontend\modules\photo\components\helpers\MoveHelper;
use site\frontend\modules\photo\components\observers\PhotoCollectionObserver;
use site\frontend\modules\photo\components\UtilityHelper;
use site\frontend\modules\photo\models\PhotoCollection;
use site\frontend\modules\users\models\User;
use site\frontend\components\api\ApiController;

class CollectionsApiController extends ApiController
{
    public function actionAttaches($collectionId, $length, $offset)
    {
        $collection = $this->getCollection($collectionId);
        $observer = PhotoCollectionObserver::getObserver($collection);
        $this->success = true;
        $this->data = array('attaches' => $observer->getSlice($length, $offset));
    }

    public function actionCollections()
    {
        $user = User::model()->findByPk(\Yii::app()->user->id);
        if ($user === null) {
            throw new \CHttpException(404, 'Пользователь не найден');
        }
        $this->success = true;
        $this->data = $user->photoCollections;
    }

    public function actionSort($collectionId, $attachesIds)
    {
        $this->success = CollectionsManager::sort($collectionId, $attachesIds);
    }

    public function actionMove($sourceCollectionId, $destinationCollectionId, $attachesIds)
    {
        $this->success = CollectionsManager::moveAttaches($sourceCollectionId, $destinationCollectionId, $attachesIds);
    }

    /**
     * @param $collectionId
     * @return PhotoCollection
     * @throws \CHttpException
     */
    protected function getCollection($collectionId)
    {
        /** @var PhotoCollection $collection */
        $collection = PhotoCollection::model()->findByPk($collectionId);
        if ($collection === null) {
            throw new \CHttpException(404, 'Коллекция не найдена');
        }
        return $collection;
    }
} 