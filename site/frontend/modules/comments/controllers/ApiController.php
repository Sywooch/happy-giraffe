<?php

namespace site\frontend\modules\comments\controllers;

/**
 * Description of ApiController
 *
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{

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
                'actions' => array('get', 'list'),
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
                /** @todo добавить проверку на удаление корневого комментария */
                /** @todo добавить проверку прав */
                'remove' => array(
                    'class' => 'site\frontend\components\api\SoftDeleteAction',
                    'modelName' => '\site\frontend\modules\comments\models\Comment',
                ),
                /** @todo добавить проверку прав */
                'restore' => array(
                    'class' => 'site\frontend\components\api\SoftRestoreAction',
                    'modelName' => '\site\frontend\modules\comments\models\Comment',
                ),
        ));
    }

    public function packGet($id)
    {
        $comment = \site\frontend\modules\comments\models\Comment::model()->findByPk($id);
        if (!$comment)
            throw new \CHttpException(404, 'Комментарий ' . $id . ' не найден');
        $this->success = true;
        $this->data = $comment->toJSON();
    }

    public function actionCreate($entity, $entityId, $text, $responseId = false)
    {
        if (!\Yii::app()->user->checkAccess('createComment'))
            throw new \CHttpException('Недостаточно прав для выполнения операции', 403);
        $comment = new \site\frontend\modules\comments\models\Comment('default');
        $comment->attributes = array(
            'author_id' => \Yii::app()->user->id,
            'entity' => $entity,
            'entity_id' => $entityId,
            'text' => $text,
        );
        if ($responseId)
            $comment->response_id = $responseId;

        if ($comment->save())
        {
            $comment->refresh();
            $this->success = true;
            $this->data = $comment->toJSON();
        }
        else
        {
            $this->errorCode = 1;
            $this->errorMessage = $comment->getErrorsText();
        }
    }

    public function actionUpdate($id, $text)
    {
        $comment = \site\frontend\modules\comments\models\Comment::model()->findByPk($id);
        if (is_null($comment))
            throw new \CHttpException('Комментарий не найден', 404);
        if (!\Yii::app()->user->checkAccess('updateComment', array('entity' => $comment)))
            throw new \CHttpException('Недостаточно прав для выполнения операции', 403);
        $comment->text = $text;
        if ($comment->save())
        {
            $comment->refresh();
            $this->success = true;
            $this->data = $comment->toJSON();
        }
        else
        {
            $this->errorCode = 1;
            $this->errorMessage = $comment->getErrorsText();
        }
    }

    public function actionList($entity, $entityId, $listType = 'list', $rootCount = false, $dtimeFrom = 0)
    {
        $model = \site\frontend\modules\comments\models\Comment::model()->specialSort();
        $model->byEntity(array('entity' => $entity, 'entity_id' => $entityId));
        if ($dtimeFrom)
            $model->dtimeFrom($dtimeFrom);
        if ($rootCount && $listType)
            $model->rootLimit($rootCount, $listType);

        $models = $model->findAll();

        $this->data['list'] = array_map(function($item)
            {
                return $item->toJSON();
            }, $models);
        $this->data['isLast'] = false;
        $this->success = true;
    }

    public function afterAction($action)
    {
        if ($this->success == true && in_array($action, array('create', 'update', 'delete', 'restore')))
        {
            $types = array(
                'create' => \CometModel::COMMENTS_NEW,
                'update' => \CometModel::COMMENTS_UPDATE,
                'delete' => \CometModel::COMMENTS_DELETE,
                'restore' => \CometModel::COMMENTS_RESTORE,
            );
            $this->send($comment->channel, $this->data, \site\frontend\modules\comments\models\Comment::getChannel($this->data));
        }

        return parent::afterAction($action);
    }

}

?>
