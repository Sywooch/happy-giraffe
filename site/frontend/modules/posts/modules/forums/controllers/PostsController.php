<?php

namespace site\frontend\modules\posts\modules\forums\controllers;

class PostsController extends \LiteController
{

/**
     * @var User
     */
    public $user;
    public $rubric_id;
    public $tempLayout = true;

    public $layout = '//layouts/lite/posts';

    public $litePackage = 'add_posts';

    public $urlReferrer = '/posts/forums/default/index';

    public $windowHeaderTitle = 'Добавить запись в форум';

    public function actionNewAddForm($id = null, $club_id = null)
    {
        $type = 1;

        $this->user = $this->loadUser(\Yii::app()->user->id);
        if ($id === null) {
                $model = new \CommunityContent('default_club');
            $model->type_id = $type;
            $slug = $model->type->slug;
            $slaveModelName = 'Community' . ucfirst($slug);
            $slaveModel = new $slaveModelName();
        } else {
                $model = \CommunityContent::model()->findByPk($id);
            $slaveModel = $model->getContent();
        }

        if (!$model->isNewRecord && !$model->canEdit())
            \Yii::app()->end();

        if ($club_id){
            $rubricsList = array_map(function ($rubric) {
                return array(
                    'id' => $rubric->id,
                    'title' => $rubric->title,
                );
            }, \CommunityClub::model()->findByPk($club_id)->communities);
        }else{
            $rubricsList = array_map(function ($rubric) {
                return array(
                    'id' => $rubric->id,
                    'title' => $rubric->title,
                );
            }, $this->user->blog_rubrics);
        }

        $json = array(
            'title' => (string)$model->title,
            'privacy' => (int)$model->privacy,
            'text' => (string)$slaveModel->text,
            'rubricsList' => $rubricsList,
            'selectedRubric' => $id === null ? null : $model->rubric_id,
        );


        $this->render('newAddForm', compact('model', 'slaveModel', 'json', 'club_id'));

    }

    public function loadUser($id)
    {
        $model = \User::model()->with(array('blog_rubrics', 'avatar'))->findByPk($id);
        if ($model === null)
            throw new \CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

}
