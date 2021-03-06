<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 18/09/14
 * Time: 12:32
 */

namespace site\frontend\modules\photo\controllers;
use site\frontend\components\api\ApiController;
use site\frontend\modules\photo\models\PhotoAlbum;

class AlbumsApiController extends ApiController
{
    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
            'create' => array(
                'class' => 'site\frontend\components\api\CreateAction',
                'modelName' => '\site\frontend\modules\photo\models\PhotoAlbum',
                'checkAccess' => 'createPhotoAlbum',
            ),
            'edit' => array(
                'class' => 'site\frontend\components\api\EditAction',
                'modelName' => '\site\frontend\modules\photo\models\PhotoAlbum',
                'checkAccess' => 'editPhotoAlbum',
            ),
            'remove' => array(
                'class' => 'site\frontend\components\api\SoftDeleteAction',
                'modelName' => '\site\frontend\modules\photo\models\PhotoAlbum',
                'checkAccess' => 'removePhotoAlbum',
            ),
            'restore' => array(
                'class' => 'site\frontend\components\api\SoftRestoreAction',
                'modelName' => '\site\frontend\modules\photo\models\PhotoAlbum',
                'checkAccess' => 'restorePhotoAlbum',
            ),
        ));
    }

    /**
     * @param $userId
     * @param bool $notEmpty
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