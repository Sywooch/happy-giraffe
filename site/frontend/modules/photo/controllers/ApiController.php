<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 18/09/14
 * Time: 12:32
 */

namespace site\frontend\modules\photo\controllers;
use site\frontend\modules\photo\components\observers\PhotoCollectionObserver;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoCollection;
use site\frontend\modules\users\models\User;

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionUserAlbums($userId, $includingEmpty = false)
    {
        header('Content-Type: application/json');
        $criteria = new \CDbCriteria();
        $criteria->with = array(
            'photoCollections' => array(
                'scopes' => $includingEmpty ? array() : array('notEmpty'),
            ),
        );
        $albums = PhotoAlbum::model()->user($userId)->findAll($criteria);
        $this->success = true;
        $this->data = array('albums' => new \CJavaScriptExpression(\HJSON::encode($albums)));
    }

    public function actionCollectionAttaches($collectionId, $length, $offset)
    {
        /** @var PhotoCollection $collection */
        $collection = PhotoCollection::model()->findByPk($collectionId);
        if ($collection === null) {
            throw new \CHttpException(404, 'Коллекция не найдена');
        }
        $observer = PhotoCollectionObserver::getObserver($collection);
        $this->success = true;
        $this->data = array('attaches' => $observer->getSlice($length, $offset));
    }

    public function actionMyCollections()
    {
        $user = User::model()->findByPk(\Yii::app()->user->id);
        if ($user === null) {
            throw new \CHttpException(404, 'Пользователь не найден');
        }
        $this->success = true;
        $this->data = $user->photoCollections;
    }
} 