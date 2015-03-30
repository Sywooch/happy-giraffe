<?php

namespace site\frontend\modules\som\modules\photopost\controllers;

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
                'actions' => array('get', 'remove', 'restore', 'create', 'update'),
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

    public function packGet($id)
    {
        $comment = $this->getModel(self::$model, $id, false);
        $this->success = true;
        $this->data = $comment->toJSON();
    }

    public function actionCreate($title, $collectionId, $isDraft = 0)
    {
        if (!\Yii::app()->user->checkAccess('createPhotopost')) {
            throw new \CHttpException('Недостаточно прав для выполнения операции', 403);
        }

        $model = self::$model;
        $photopost = new $model('default');
        $photopost->attributes = array(
            'authorId' => \Yii::app()->user->id,
            'title' => $title,
            'collectionId' => $collectionId,
        );
        if ($photopost->save()) {
            $photopost->refresh();
            $this->success = true;
            $this->data = $photopost->toJSON();
        } else {
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
        if ($photopost->save()) {
            $photopost->refresh();
            $this->success = true;
            $this->data = $photopost->toJSON();
        } else {
            $this->errorCode = 1;
            $this->errorMessage = $photopost->getErrorsText();
        }
    }

}

?>
