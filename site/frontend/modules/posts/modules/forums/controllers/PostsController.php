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

    public $windowHeaderTitle = '';

    public function actionEditForm($id = null)
    {
        $this->windowHeaderTitle = 'Редактировать тему на форуме';
        $this->pageTitle = $this->windowHeaderTitle;
        $this->user = $this->loadUser(\Yii::app()->user->id);
        $model = \CommunityContent::model()->findByPk($id);
        if (empty($model)) {
            throw new CHttpException(404);
        }
        $slaveModel = $model->getContent();
        if ($model->isNewRecord && !$model->canEdit())
            \Yii::app()->end();
        $rubrics = $model->community->club->communities;
        $rubricsList = array_map(function ($rubric) {
            return array(
                'id' => $rubric->id,
                'title' => $rubric->title,
            );
        }, $rubrics);

        $json = array(
            'isNew' => false,
            'title' => (string)$model->title,
            'privacy' => (int)$model->privacy,
            'text' => (string)$slaveModel->text,
            'rubricsList' => $rubricsList,
            'selectedRubric' => $id === null ? null : $model->rubric_id,
        );

        $this->render('form', compact('model', 'slaveModel', 'json', 'club_id'));
    }

    public function actionAddForm($club_id = null)
    {
        $this->windowHeaderTitle = 'Создать тему на форуме';
        $this->pageTitle = $this->windowHeaderTitle;
        $type = 1;

        $this->user = $this->loadUser(\Yii::app()->user->id);
        
        $model = new \CommunityContent('default_club');
        $model->type_id = $type;
        $slug = $model->type->slug;
        $slaveModelName = 'Community' . ucfirst($slug);
        $slaveModel = new $slaveModelName();
        
        if (!$model->isNewRecord && !$model->canEdit())
            \Yii::app()->end();

       $rubricsList = array_map(function ($rubric) {
                return array(
                    'id' => $rubric->id,
                    'title' => $rubric->title,
                );
            }, \CommunityClub::model()->findByPk($club_id)->communities);

        $json = array(
            'isNew' => true,
            'title' => (string)$model->title,
            'privacy' => (int)$model->privacy,
            'text' => (string)$slaveModel->text,
            'rubricsList' => $rubricsList,
            'selectedRubric' => null,
        );


        $this->render('form', compact('model', 'slaveModel', 'json', 'club_id'));

    }

    public function loadUser($id)
    {
        $model = \User::model()->with(array('blog_rubrics', 'avatar'))->findByPk($id);
        if ($model === null)
            throw new \CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

}
