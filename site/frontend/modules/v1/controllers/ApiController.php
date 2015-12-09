<?php

namespace site\frontend\modules\v1\controllers;

use site\frontend\modules\v1\components\V1ApiController;

class ApiController extends V1ApiController
{
    #region Actions
    public function actions()
    {
        return array(
            'login' => array(
                'class' => 'site\frontend\modules\v1\actions\LoginAction',
            ),
            'sections' => array(
                'class' => 'site\frontend\modules\v1\actions\SectionsAction',
            ),
            'clubs' => array(
                'class' => 'site\frontend\modules\v1\actions\ClubsAction',
            ),
            'forums' => array(
                'class' => 'site\frontend\modules\v1\actions\ForumsAction',
            ),
            'rubrics' => array(
                'class' => 'site\frontend\modules\v1\actions\RubricsAction',
            ),
            'users' => array(
                'class' => 'site\frontend\modules\v1\actions\UsersAction',
            ),
            'comments' => array(
                'class' => 'site\frontend\modules\v1\actions\CommentsAction',
            ),
            'posts' => array(
                'class' => 'site\frontend\modules\v1\actions\PostsAction',
            ),
            'onair' => array(
                'class' => 'site\frontend\modules\v1\actions\OnairAction',
            ),
            'postContent' => array(
                'class' => 'site\frontend\modules\v1\actions\PostContentAction',
            ),
            'postLabel' => array(
                'class' => 'site\frontend\modules\v1\actions\PostLabelAction',
            ),
            'postTag' => array(
                'class' => 'site\frontend\modules\v1\actions\PostTagAction',
            ),
        );
    }
    #endregion

    #region Else
    private function isBehaviorExists($name, $behaviors) {
        foreach ($behaviors as $key => $value) {
            if ($key == $name) {
                return true;
            }
        }

        return false;
    }

    private function detach($name, $model) {
        if ($this->isBehaviorExists($name, $model->behaviors())) {
            $model->detachBehavior($name);
        }
    }
    #endregion
}