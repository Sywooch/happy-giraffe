<?php

class DefaultController extends HController
{
    public $layout = '//layouts/new';

    public function filters()
    {
        return array(
            'ajaxOnly + Calculate',
        );
    }

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Вес при беременности. Прибавка веса во время беременности по неделям';

        $this->render('index');
    }

    public function actionCalculate()
    {
        if (isset($_POST['PregnantParamsForm'])) {
            $service = Service::model()->findByPk(5);
            $service->userUsedService();

            $model = new PregnantParamsForm();
            $model->attributes = $_POST['PregnantParamsForm'];
            $this->performAjaxValidation($model);

            $model->CalculateData();

            $this->renderPartial('data', array(
                'model' => $model,
            ));
        }
    }

    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'pregnant-params-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}