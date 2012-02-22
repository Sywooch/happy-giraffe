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

    public function actionAccept($id)
    {
        $model = Report::model()->findByPk($id);
        $model->accepted = 1;
        $model->save();
    }
}
