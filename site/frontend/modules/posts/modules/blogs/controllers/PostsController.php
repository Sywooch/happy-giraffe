<?php

namespace site\frontend\modules\posts\modules\blogs\controllers;

class PostsController extends \LiteController
{

    /**
     * Пакет стилей
     *
     * @var string
     */
    public $litePackage = 'add_posts';

    public $windowHeaderTitle = 'Добавить запись в блог';

    public function actionNewAddForm()
    {
        $model = new \BlogContent('default');
        $model->type_id = \CommunityContentType::TYPE_POST;

        $slug = $model->type->slug;

        $slaveModelName = 'Community' . ucfirst($slug);
        $slaveModel = new $slaveModelName();

        \Yii::app()->clientScript->useAMD = true;

        if (! $model->isNewRecord && ! $model->canEdit())
        {
            \Yii::app()->end();
        }

        $json = [
            'title'    => (string) $model->title,
            'privacy'  => (int) $model->privacy,
            'text'     => (string) $slaveModel->text,
        ];
$this->layout = '//layouts/lite/posts';
        $this->render('newAddForm', compact('model', 'slaveModel', 'json'));
    }

}
