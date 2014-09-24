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

class AlbumsApiController extends \site\frontend\components\api\ApiController
{
    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
            'remove' => array(
                'class' => 'site\frontend\components\api\SoftDeleteAction',
                'modelName' => '\site\frontend\modules\photo\models\PhotoAlbum',
            ),
            'create' => array(
                'class' => 'site\frontend\components\api\CreateAction',
                'modelName' => '\site\frontend\modules\photo\models\PhotoAlbum',
            ),
            'edit' => array(
                'class' => 'site\frontend\components\api\EditAction',
                'modelName' => '\site\frontend\modules\photo\models\PhotoAlbum',
            ),
        ));
    }

    /**
     * @param $userId
     * @param bool $notEmpty
     * @todo возможно параметр notEmpty нужно дополнительно корректировать сервером в случае, если клиент пытается
     * получить список альбомов другого пользователя, включающий пустые альбомы - зависит от требований
     */
    public function actionGetByUser($userId, $notEmpty = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = array(
            'photoCollections' => array(
                'scopes' => $notEmpty ? array('notEmpty') : array(),
            ),
        );
        $albums = PhotoAlbum::model()->user($userId)->findAll($criteria);
        $this->success = true;
        $this->data = array('albums' => new \CJavaScriptExpression(\HJSON::encode($albums)));
    }
} 