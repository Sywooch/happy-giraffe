<?php

namespace site\frontend\modules\comments\controllers;

use Aws\CloudFront\Exception\Exception;
use site\frontend\modules\comments\models\Comment;

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
                'actions' => array('get', 'list', 'onAir'),
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
                    'remove' => array(
                        'class' => 'site\frontend\components\api\SoftDeleteAction',
                        'modelName' => '\site\frontend\modules\comments\models\Comment',
                        'checkAccess' => 'removeComment',
                    ),
                    'restore' => array(
                        'class' => 'site\frontend\components\api\SoftRestoreAction',
                        'modelName' => '\site\frontend\modules\comments\models\Comment',
                        'checkAccess' => 'removeComment',
                    ),
        ));
    }

    public function packGet($id)
    {
        $comment = $this->getModel('\site\frontend\modules\comments\models\Comment', $id, true);
        $this->success = true;
        $this->data = $comment->toJSON();
    }

    public function actionCreate($entity, $entityId, $text, $responseId = false)
    {
        if (!\Yii::app()->user->checkAccess('createComment'))
        {
            throw new \CHttpException('Недостаточно прав для выполнения операции', 403);
        }


        $comment = new \site\frontend\modules\comments\models\Comment();
        $prufer = \site\frontend\components\PreparedHTMLPurifier::getInstans();
        $text = $prufer->purifyUserHTML($text);
        if (strlen($text == ''))
        {
            throw new \CHttpException('Пустой текст в комментарии', 403);
        }
        $comment->attributes = array(
            'author_id' => \Yii::app()->user->id,
            'entity' => $entity,
            'entity_id' => $entityId,
            'text' => $text,
        );
        if ($responseId)
        {
            $comment->response_id = $responseId;
        }

        if ($entity != 'BlogContent')
        {
            $content = \site\frontend\modules\posts\models\Content::model()->find(array(
                'condition' => "originEntity = '" . $entity . "' and originEntityId = " . $entityId));
        }
        else
        {
            $content = \site\frontend\modules\posts\models\Content::model()->find(array(
                'condition' => "originService = 'oldBlog' and originEntityId = " . $entityId));
        }

        $comment->new_entity_id = $content->id;

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
        $comment = $this->getModel('\site\frontend\modules\comments\models\Comment', $id, 'updateComment');
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
        \site\frontend\modules\notifications\behaviors\ContentBehavior::$active = true;

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

    public function actionOnAir($limit, $offset = 0)
    {
        $criteria = new \CDbCriteria();
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->order = 't.created DESC';
        $models = Comment::model()->findAll($criteria);

        $this->data = array_map(function($item)
        {
            return $item->toJSON();
        }, $models);
        $this->success = true;
    }

    public function afterAction($action)
    {
        if ($this->success == true && in_array($action->id, array('create', 'update', 'remove', 'restore')))
        {
            $types = array(
                'create' => \CometModel::COMMENTS_NEW,
                'update' => \CometModel::COMMENTS_UPDATE,
                'remove' => \CometModel::COMMENTS_DELETE,
                'restore' => \CometModel::COMMENTS_RESTORE,
            );
            $this->send(\site\frontend\modules\comments\models\Comment::getChannel($this->data), $this->data, $types[$action->id]);
        }

        return parent::afterAction($action);
    }

}

?>
