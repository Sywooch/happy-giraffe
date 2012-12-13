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
        $this->pageTitle = 'Толщина плаценты по неделям. Толщина плаценты норма';

        $model = new PlacentaThicknessForm;
        $this->render('index', array('model' => $model));
    }

    public function actionCalculate()
    {
        if (isset($_POST['PlacentaThicknessForm'])) {
            $service = Service::model()->findByPk(6);
            $service->userUsedService();

            $model = new PlacentaThicknessForm;
            $model->attributes = $_POST['PlacentaThicknessForm'];
            $this->performAjaxValidation($model);

            $placentaThickness = PlacentaThickness::model()->cache(3600)->find(array(
                'condition' => 'week=' . $model->week,
                'select' => array('min', 'avg', 'max')
            ));
            $this->renderPartial('result', array(
                'placentaThickness' => $placentaThickness,
                'model' => $model
            ));
        }
    }

    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'placenta-thickness-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}