<?php

namespace site\frontend\modules\posts\modules\blogs\controllers;

class PostsController extends \LiteController
{

    public $litePackage = 'add_posts';

    public $layout = '//layouts/lite/posts';

    public $windowHeaderTitle = '';

    public function actionEditForm($id)
    {
        if( \Yii::app()->user->isGuest){
            throw new \CHttpException(403);
        }
         \Yii::app()->clientScript->useAMD = true;
        $this->windowHeaderTitle = 'Редактировать запись в блоге';
        $this->pageTitle = $this->windowHeaderTitle;
        if (empty($id)) {
            throw new \CHttpException(400);
        }
        $model = \BlogContent::model()->findByPk($id);
        if (empty($model)) {
            throw new \CHttpException(404);
        }
         if ($model->isNewRecord && !$model->canEdit()) {
            throw new \CHttpException(403);
        }

        $slug = $model->type->slug;

        $slaveModel = $model->getContent();

       

        if (! $model->isNewRecord && ! $model->canEdit())
        {
            \Yii::app()->end();
        }

        $json = [
            'isNew' => false,
            'title'    => (string) $model->title,
            'privacy'  => (int) $model->privacy,
            'text'     => (string) $slaveModel->text,
        ];

        $this->render('form', compact('model', 'slaveModel', 'json'));
    }

    public function actionAddForm()
    {
        if( \Yii::app()->user->isGuest){
            throw new \CHttpException(403);
        }
        \Yii::app()->clientScript->useAMD = true;
        $this->windowHeaderTitle = 'Добавить запись в блог';
        $this->pageTitle = $this->windowHeaderTitle;
        $model = new \BlogContent('default');
        $model->type_id = \CommunityContentType::TYPE_POST;

        $slug = $model->type->slug;

        $slaveModelName = 'Community' . ucfirst($slug);
        $slaveModel = new $slaveModelName();

        if (! $model->isNewRecord && ! $model->canEdit())
        {
            throw new \CHttpException(403);
        }

        $json = [
            'isNew' => true,
            'title'    => (string) $model->title,
            'privacy'  => (int) $model->privacy,
            'text'     => (string) $slaveModel->text,
        ];

        $this->render('form', compact('model', 'slaveModel', 'json'));
    }

}
