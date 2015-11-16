<?php

namespace site\frontend\modules\v1\controllers;

use site\frontend\modules\users\models\User;
use site\frontend\modules\comments\models\Comment;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\posts\models\Tag;
use site\frontend\modules\som\modules\activity\models\Activity;
//use site\frontend\modules\posts\models\*;

class ApiController extends \V1ApiController
{
    #region Fields
    #endregion

    #region route
    /**
     * Routing a request to a method by request type.
     *
     * @param string $get - get method name
     * @param string $post - post method name
     * @param string $update - update method name
     * @param string $delete - delete method name
     */
    public function route($get, $post, $update, $delete) {
        switch(\Yii::app()->request->requestType){
            case 'GET':
                $this->requestType = 'Param';
                $this->$get();
                break;
            case 'POST':
                $this->requestType = 'Post';
                $this->$post();
                break;
            case 'PUT':
                $this->requestType = 'Put';
                $this->$update();
                break;
            case 'DELETE':
                $this->data = 'delete';
                $this->requestType = 'Delete';
                $this->$delete();
                break;
            default:
                $this->requestType = 'Param';
                $this->$get();
        }
    }
    #endregion

    #region Sections
    public function actionSections() {
        $this->route('getSections', 'getSections', 'getSections', 'getSections');
    }

    private function getSections() {
        $this->get(\CommunitySection::model());
    }
    #endregion

    #region Clubs
    public function actionClubs() {
        $this->route('getClubs', 'getClubs', 'getClubs', 'getClubs');
    }

    private function getClubs() {
        $this->get(\CommunityClub::model());
    }
    #endregion

    #region Forums
    public function actionForums() {
        $this->route('getForums', 'getForums', 'getForums', 'getForums');
    }

    private function getForums() {
        $this->get(\Community::model());
    }
    #endregion

    #region Rubrics
    public function actionRubrics() {
        $this->route('getRubrics', 'getRubrics', 'getRubrics', 'getRubrics');
    }

    private function getRubrics() {
        $this->get(\CommunityRubric::model());
    }
    #endregion

    #region Users
    public function actionUsers() {
        $this->route('getUsers', 'getUsers', 'getUsers', 'getUsers');
    }

    private function getUsers() {
        $this->get(User::model());
    }
    #endregion

    #region Comments
    public function actionComments() {
        $this->route('getComments', 'postComment', 'updateComment', 'deleteComment');
    }

    private function getComments() {
        $this->get(Comment::model());
    }

    private function postComment() {
        $required = array(
            'author_id' => true,
            'entity' => true,
            'entity_id' => true,
            'text' => true,
            'response_id' => false
        );


        if ($this->checkParams($required)) {
            $comment = new Comment('default');
            try {
                $comment->attributes = $this->getParams($required);
            } catch (Exception $e) {
                $this->data = $e->getMessage();
            }

            if ($comment->save()) {
                $comment->refresh();
                $this->data = $comment->toJSON();

                $this->push(get_class($comment), \CometModel::COMMENTS_NEW);
            } else {
                $this->data = $comment->getErrorsText();
            }
        } else {
            $this->data = 'Parameters missing';
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

    private function updateComment() {
        $required = array(
            'id' => true,
            'text' => true
        );

        if ($this->checkParams($required)) {
            //extract($this->getParams($required));
            $params = $this->getParams($required);
            try {
                $comment = Comment::model()->findByPk($params['id']);
                $comment->text = $params['text'];
            } catch (Exception $e) {
                $this->data = $e->getMessage();
            }
            if ($comment->save()) {
                $comment->refresh();
                $this->data = $comment->toJSON();

                $this->push(get_class($comment), \CometModel::COMMENTS_UPDATE);
            } else {
                $this->data = $comment->getErrorsText();
                $this->data = 'Parameters checked';
            }
        } else {
            $this->data = 'Parameters missing';
        }
    }

    private function deleteComment() {
        $required = array ('id' => true);

        if ($this->checkParams($required)) {
            $params = $this->getParams($required);
            try {
                $comment = Comment::model()->findByPk($params['id']);
            } catch (Exception $e) {
                $this->data = $e->getMessage();
            }

            if ($comment->softDelete()) {
                $this->data = $comment->toJSON();

            } else {
                $this->data = $comment->getErrorsText();
                $this->data = $comment->id;
            }
        } else {
            $this->data = 'Parameters missing';
        }
    }
    #endregion

    #region Posts
    public function actionPosts() {
        $this->route('getPosts', 'getPosts', 'getPosts', 'getPosts');
    }

    private function getPosts() {

    }

    private function postPost() {

    }

    public function actionPostContent() {
        $this->route('getPostsContent', 'getPostsContent', 'getPostsContent', 'getPostsContent');
    }

    private function getPostsContent() {
        $this->get(Content::model());
    }

    public function actionPostLabel() {
        $this->route('getPostLabel', 'getPostLabel', 'getPostLabel', 'getPostLabel');
    }

    private function getPostLabel() {
        $this->get(Label::model());
    }

    public function actionPostTag() {
        $this->route('getPostTag', 'getPostTag', 'getPostTag', 'getPostTag');
    }

    private function getPostTag() {
        $this->get(Tag::model());
    }
    #endregion

    #region Onair
    public function actionOnair() {
        $this->route('getOnair', 'getOnair', 'getOnair', 'getOnair');
    }

    private function getOnair() {
        $this->get(Activity::model());
    }
    #endregion
}