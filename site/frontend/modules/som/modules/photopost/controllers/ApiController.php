<?php

namespace site\frontend\modules\som\modules\photopost\controllers;

use site\frontend\modules\photo\models\PhotoCollection;

/**
 * Description of ApiController
 *
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{

    public static $model = '\site\frontend\modules\som\modules\photopost\models\Photopost';

    public function filters()
    {
        return \CMap::mergeArray(parent::filters(), array(
                    'accessControl',
        ));
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('get'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('remove', 'restore', 'create', 'update', 'createByPhoto'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
                    'get' => 'site\frontend\components\api\PackAction',
                    'remove' => array(
                        'class' => 'site\frontend\components\api\SoftDeleteAction',
                        'modelName' => self::$model,
                        'checkAccess' => 'removePhotopost',
                    ),
                    'restore' => array(
                        'class' => 'site\frontend\components\api\SoftRestoreAction',
                        'modelName' => self::$model,
                        'checkAccess' => 'removePhotopost',
                    ),
        ));
    }

    /**
     * создание фотопоста из списка фото
     * @param array $photosIds
     * @param string $title
     * @author crocodile
     */
    public function actionCreateByPhoto(array $photoIds, $title, $photopostCover, $isDraft)
    {
        if (\Yii::app()->db instanceof \DbConnectionMan)
        {
            /*
             * Отключим слейвы, чтобы Collection нашло фото - костыль костылём,
             * но тут так модно делать, а на правильный вариант нет ни времени
             * ни жиелания админа работать.
             */
            \Yii::app()->db->enableSlave = false;
        }
        if (!\Yii::app()->user->checkAccess('createPhotopost'))
        {
            throw new \CHttpException('Недостаточно прав для выполнения операции', 403);
        }
        if (sizeof($photoIds) == 0)
        {
            throw new \CHttpException('Не корректные параметры', 403);
        }
        /** @var \site\frontend\modules\photo\models\PhotoCollection $collection */
        $collection = new PhotoCollection();
        $collection->save();
        $collection->attachPhotos($photoIds);
        $collection->save();

        if ($photopostCover > 0)
        {
            $attaches = $collection->observer->getSlice(0, null, false);
            foreach ($attaches AS $att)
            {
                if ($att->photo->id == $photopostCover)
                {
                    $collection->setCover($att);
                    break;
                }
            }
            $collection->save();
        }

        $model = self::$model;
        $photopost = new $model('default');
        $photopost->attributes = array(
            'authorId' => \Yii::app()->user->id,
            'title' => $title,
            'collectionId' => $collection->id,
        );
        if ($photopost->save())
        {
            $photopost->refresh();
            $this->success = true;
            $this->data = $photopost->toJSON();
        }
        else
        {
            $this->errorCode = 1;
            $this->errorMessage = $photopost->getErrorsText();
        }
    }

    public function packGet($id)
    {
        $comment = $this->getModel(self::$model, $id, true);
        $this->success = true;
        $this->data = $comment->toJSON();
    }

    public function actionCreate($title, $collectionId, $isDraft = 0)
    {
        if (!\Yii::app()->user->checkAccess('createPhotopost'))
        {
            throw new \CHttpException('Недостаточно прав для выполнения операции', 403);
        }

        $model = self::$model;
        $photopost = new $model('default');
        $photopost->attributes = array(
            'authorId' => \Yii::app()->user->id,
            'title' => $title,
            'collectionId' => $collectionId,
        );
        if ($photopost->save())
        {
            $photopost->refresh();
            $this->success = true;
            $this->data = $photopost->toJSON();
        }
        else
        {
            $this->errorCode = 1;
            $this->errorMessage = $photopost->getErrorsText();
        }
    }

    public function actionUpdate($id, $title, $collectionId, $isDraft = 0)
    {
        $photopost = $this->getModel(self::$model, $id, 'updatePhotopost');
        $photopost->title = $title;
        $photopost->collectionId = $collectionId;
        $photopost->isDraft = $isDraft;
        if ($photopost->save())
        {
            $photopost->refresh();
            $this->success = true;
            $this->data = $photopost->toJSON();
        }
        else
        {
            $this->errorCode = 1;
            $this->errorMessage = $photopost->errors;
        }
    }

}

?>
