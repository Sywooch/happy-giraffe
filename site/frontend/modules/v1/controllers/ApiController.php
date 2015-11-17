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
        $this->route('getPosts', 'postPost', 'getPosts', 'getPosts');
    }

    private function getPosts() {

    }

    private function postPost() {
        //���� ��� ��������.
        $contest_id = \Yii::app()->request->getPost('contest_id');

        if (isset($_POST['type'])) {
            if ($_POST['type'] == "forum") {
                $model = new \CommunityContent();
            } else {
                $model = new \BlogContent();
            }
        } else {
            $this->data = print_r($_POST, true);
            return;
        }
        $new = $model->isNewRecord;

        if (!$new && !$model->canEdit()) {
            $this->data = 'Missing post.';
        } else {
            $model->scenario = 'default_club';

            $required = array(
                'author_id' => true,
                'type_id' => true,
                'title' => true,
                'rubric_id' => true,
                'text' => true,
                'type' => true,
                'photos' => false,
                'link' => false
            );

            if ($this->checkParams($required)) {
                $params = $this->getParams($required);
                $model->attributes = array(
                    'author_id' => $params['author_id'],
                    'type_id' => $params['type_id'],
                    'title' => $params['title'],
                    'rubric_id' => $params['rubric_id']
                );

                $names = array(
                    1 => array(
                        'name' => 'CommunityPost',
                        'filter' => array('text' => 'text')
                    ),
                    2 => array(
                        'name' => 'CommunityVideo',
                        'filter' => array('text' => 'text', 'link' => 'link'),
                    ),
                    3 => array(
                        'name' => 'CommunityPhotoPost',
                        'filter' => array('text' => 'text', 'photos' => 'photos'),
                    ),
                );

                $slaveModelName = $names[$params['type_id']]['name'];

                $slaveParams = $this->getFilteredParams($params, $names[$params['type_id']]['filter'], false);

                $slaveModel = new $slaveModelName();
                if ($contest_id !== null) {
                    $slaveModel->isContestWork = true;
                }
                $slaveModel->attributes = $slaveParams;

                $slug = $model->type->slug;

                $model->$slug = $slaveModel;

                try {
                    if ($model->withRelated->save(true, array($slug))) {
                        $this->data = $model->id;/*array($model, $slaveModel);*/
                    } else {
                        $this->data = 'Saving failed.';
                    }
                } catch (Exception $e) {
                    $this->data = $e->getMessage();
                }
            } else {
                $this->data = 'Parameters missing.';
            }

        }
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