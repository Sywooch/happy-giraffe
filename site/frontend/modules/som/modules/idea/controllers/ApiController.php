<?php

namespace site\frontend\modules\som\modules\idea\controllers;

use site\frontend\modules\som\modules\idea\models\Idea;

class ApiController extends \site\frontend\components\api\ApiController
{
    public static $model = '\site\frontend\modules\som\modules\idea\models\Idea';

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
                'actions' => array('remove', 'restore', 'create', 'update'),
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
                'checkAccess' => 'removeIdea',
            ),
            'restore' => array(
                'class' => 'site\frontend\components\api\SoftRestoreAction',
                'modelName' => self::$model,
                'checkAccess' => 'removeIdea',
            ),
        ));
    }

    public function packGet($id)
    {
        $idea = $this->getModel(self::$model, $id, true);
        $this->success = true;
        $this->data = $idea->toJSON();
    }

    public function actionCreate($title, $collectionId, $isDraft = 0)
    {
        /**@todo: fix access denied*/
        /*if (!\Yii::app()->user->checkAccess('createIdea')) {
            //throwing exception grants 502 error
            throw new \CHttpException('Ќедостаточно прав дл€ выполнени€ операции', 403);
        }*/

        $model = self::$model;
        $idea = new $model('default');
        $idea->attributes = array(
            'authorId' => \Yii::app()->user->id,
            'title' => $title,
            'collectionId' => $collectionId,
        );
        if ($idea->save()) {
            $idea->refresh();
            $this->success = true;
            $this->data = $idea->toJSON();
        } else {
            $this->errorCode = 1;
            $this->errorMessage = $idea->getErrorsText();
        }
    }

    public function actionUpdate($id, $title, $collectionId, $isDraft = 0)
    {
        $idea = $this->getModel(self::$model, $id, 'updateIdea');
        $idea->title = $title;
        $idea->collectionId = $collectionId;
        $idea->isDraft = $isDraft;
        if ($idea->save()) {
            $idea->refresh();
            $this->success = true;
            $this->data = $idea->toJSON();
        } else {
            $this->errorCode = 1;
            $this->errorMessage = $idea->errors;
        }
    }

    public function actionGet($page = 1)
    {
        $ideas = Idea::model()->findAll(array(
            'order' => 't.id desc',
            'limit' => 20,
            'offset' => ($page - 1) * 20,
            'with' => array('author', 'collection'),
        ));

        if ($ideas) {
            $this->data = $ideas;
            $this->success = true;
        } else {
            $this->success = false;
        }
    }
}