<?php

namespace site\frontend\modules\som\modules\status\controllers;

/**
 * Description of ApiController
 *
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{

    public static $model = '\site\frontend\modules\som\modules\status\models\Status';

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
                'actions' => array('get', 'remove', 'restore', 'create', 'update', 'moods'),
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
                        'checkAccess' => 'removeStatus',
                    ),
                    'restore' => array(
                        'class' => 'site\frontend\components\api\SoftRestoreAction',
                        'modelName' => self::$model,
                        'checkAccess' => 'removeStatus',
                    ),
        ));
    }

    public function packGet($id)
    {
        $comment = $this->getModel(self::$model, $id, 'manageStatus');
        $this->success = true;
        $this->data = $comment->toJSON();
    }

    public function actionCreate($text, $mood = null)
    {
        if (!\Yii::app()->user->checkAccess('createStatus'))
            throw new \CHttpException('Недостаточно прав для выполнения операции', 403);
        $model = self::$model;
        $status = new $model('default');
        $status->attributes = array(
            'authorId' => \Yii::app()->user->id,
            'text' => $text,
            'moodId' => $mood,
        );
        if ($status->save()) {
            $status->refresh();
            $this->success = true;
            $this->data = $status->toJSON();
        } else {
            $this->errorCode = 1;
            $this->errorMessage = $status->getErrorsText();
        }
    }

    public function actionUpdate($id, $text, $mood)
    {
        $status = $this->getModel(self::$model, $id, 'updateStatus');
        $status->text = $text;
        $status->moodId = $mood;
        if ($status->save()) {
            $status->refresh();
            $this->success = true;
            $this->data = $status->toJSON();
        } else {
            $this->errorCode = 1;
            $this->errorMessage = $status->getErrorsText();
        }
    }

    public function actionMoods()
    {
        $this->success = true;
        $this->data['list'] = array_map(function($mood) {
            return array(
                'id' => $mood->id,
                'text' => $mood->text,
            );
        }, \site\frontend\modules\som\modules\status\models\Moods::model()->findAll());
    }

}

?>
