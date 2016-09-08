<?php

namespace site\frontend\modules\posts\modules\blogs\controllers;

/**
 * @author Sergey Gubarev
 */
class DefaultController extends \LiteController
{

    /**
     * Пакет стилей
     *
     * @var string
     */
    public $litePackage = 'blogs-homepage';

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see LiteController::filters()
     */
    public function filters()
    {
        return [
            [
                'COutputCache',
                'cacheID'     => 'cache',
                'duration'    => 0,
            ]
        ];
    }

    /**
     * Страница сервиса
     *
     * @param NULL|string $tab
     */
    public function actionIndex($tab = NULL)
    {
        $feedWidget = $this->createWidget('site\frontend\modules\posts\modules\blogs\widgets\feed\FeedWidget', [
            'tab' => $tab,
        ]);

        $this->render('index', compact('feedWidget'));
    }

    /**
     * Pop-up "Добавить в блог"
     */
    public function actionAddForm()
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

        $this->renderPartial('addForm', compact('model', 'slaveModel', 'json'), FALSE, TRUE);
    }

    /* public function actionTest()
    {
        $comet = new \CometModel;
        $comet->send('efir', ['foo' => 'bar'], \CometModel::BLOGS_EFIR_NEW_POST);
    }  */

}