<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\comments\models\Comment;

class CommentsAction extends RoutedAction
{
    public function run()
    {
        $this->route('getComments', 'postComment', 'updateComment', 'deleteComment');
    }

    public function getComments()
    {
        if (isset($_GET['entity_id'])) {
            $where = "new_entity_id = " . \Yii::app()->request->getParam('entity_id');
            $this->controller->get(Comment::model(), $this, $where);
        } else {
            $this->controller->get(Comment::model(), $this);
        }
    }

    public function postComment()
    {
        $required = array(
            'text' => true,
            'entity_id' => true,
            'response_id' => false
        );


        if ($this->controller->checkParams($required)) {
            $comment = new Comment('default');
            try {
                /*hate this*/
                $attributes = $this->controller->getParams($required);

                if (isset($attributes['response_id'])) {
                    $comment->response_id = $attributes['response_id'];
                }

                $content = \site\frontend\modules\posts\models\Content::model()->findByPk($attributes['entity_id']);

                $comment->attributes = array(
                    'text' => $attributes['text'],
                    'new_entity_id' => $attributes['entity_id'],
                    'entity_id' => $content->originEntityId,
                    'entity' => $content->originService == 'oldBlog' ? 'BlogContent' : $content->originEntity,
                    'author_id' => $this->controller->identity->getId(),
                );
            } catch (Exception $e) {
                $this->controller->setError($e->getMessage(), 400);
            }

            if ($comment->save()) {
                $comment->refresh();
                $this->controller->data = $comment;
                $this->controller->pushData = $comment->toJSON();

                $this->controller->push(get_class($comment), \CometModel::COMMENTS_NEW);
            } else {
                $this->controller->setError($comment->getErrorsText(), 400);
            }
        } else {
            $this->controller->setError('ParamsMissing', 400);
        }

        /*$action = function($context, $required) {
            $comment = new Comment('default');
            $comment->attributes = $context->getParams($required);
            if ($comment->save()) {
                $comment->refresh();
                $context->data - $comment->toJSON();

                $context->push()
            }
        };*/
    }

    public function updateComment()
    {
        $required = array(
            'id' => true,
            'text' => true
        );

        if ($this->controller->checkParams($required)) {
            //extract($this->getParams($required));
            $params = $this->controller->getParams($required);
            try {
                $comment = Comment::model()->findByPk($params['id']);

                if ($comment == null) {
                    $this->controller->setError("NotFound", 404);
                    return;
                }

                if (!$this->checkAccess($comment->author_id, $this->controller->identity->getId())) {
                    $this->controller->setError("NotAllowed", 403);
                    return;
                }

                $comment->text = $params['text'];
            } catch (Exception $e) {
                $this->controller->setError($e->getMessage(), 400);
            }
            if ($comment->save()) {
                $comment->refresh();
                $this->controller->data = $comment;
                $this->controller->pushData = $comment->toJSON();

                $this->controller->push(get_class($comment), \CometModel::COMMENTS_UPDATE);
            } else {
                $this->controller->setError($comment->getErrorsText(), 400);
            }
        } else {
            $this->controller->setError('ParamsMissing', 400);
        }
    }

    public function deleteComment()
    {
        $required = array ('id' => true);

        if ($this->controller->checkParams($required)) {
            $params = $this->controller->getParams($required);
            try {
                $comment = Comment::model()->findByPk($params['id']);

                if ($comment == null) {
                    $this->controller->setError("NotFound", 404);
                    return;
                }

                if (!$this->checkAccess($comment->author_id, $this->controller->identity->getId())) {
                    $this->controller->setError("NotAllowed", 403);
                    return;
                }
            } catch (Exception $e) {
                $this->controller->setError($e->getMessage(), 400);
            }

            if ($comment->softDelete()) {
                $this->controller->data = $comment;

            } else {
                $this->controller->setError($comment->getErrorsText(), 400);
            }
        } else {
            $this->controller->setError('ParamsMissing', 400);
        }
    }

    public function checkAccess($author_id, $user_id)
    {
        return $author_id == $user_id;
    }
}