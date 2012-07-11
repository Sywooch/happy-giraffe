<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eugene
 * Date: 22.02.12
 * Time: 23:02
 * To change this template use File | Settings | File Templates.
 */
class ReportsController extends BController
{
    public $section = 'club';
    public $layout = '//layouts/club';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('report'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        Yii::import('site.frontend.modules.recipeBook.models.*');
        return true;
    }

    public function actionIndex()
    {
        $model = new Report('search');
        $model->unsetAttributes();
        $model->accepted = 0;

        if(($attributes = Yii::app()->request->getQuery('Report')) !== false)
            $model->attributes = $attributes;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionSpam()
    {
        $model = new Report('search');
        $model->unsetAttributes();
        $model->accepted = 0;
        $model->type = 0;

        if(($attributes = Yii::app()->request->getQuery('Report')) !== false)
            $model->attributes = $attributes;

        $this->render('spam', array(
            'model' => $model,
        ));
    }

    public function actionSpamView($id)
    {
        $model = new Report('search');
        $model->unsetAttributes();
        $model->breaker_id = $id;
        $model->type = 0;

        $breaker = User::model()->findByPk($id);

        $this->render('spam_view', array(
            'model' => $model,
            'breaker' => $breaker,
        ));
    }

    public function actionAccept($id)
    {
        $model = Report::model()->findByPk($id);
        $model->accepted = 1;
        $model->save();
    }

    public function actionBlockUser($id)
    {
        User::model()->updateByPk($id, array('blocked' => 1));
        $this->redirect(array('club/reports/spamView', 'id' => $id));
    }
}
