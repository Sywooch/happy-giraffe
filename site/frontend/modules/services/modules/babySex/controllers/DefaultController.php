<?php

class DefaultController extends HController
{
    public $layout = '//layouts/new';

    public function filters()
    {
        return array(
            'ajaxOnly + bloodUpdate, japanCalc, ovulationCalc',
        );
    }

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * @sitemap
     */
    public function actionBloodRefresh()
    {
        $service = Service::model()->findByPk(22);
        $this->render('blood_refresh', compact('service'));
    }

    /**
     * @sitemap
     */
    public function actionJapan()
    {
        $service = Service::model()->findByPk(21);
        $this->render('japan', compact('service'));
    }

    /**
     * @sitemap
     */
    public function actionBlood()
    {
        $service = Service::model()->findByPk(23);
        $this->render('blood_group', compact('service'));
    }

    /**
     * @sitemap
     */
    public function actionChina()
    {
        $service = Service::model()->findByPk(20);
        if (Yii::app()->request->isAjaxRequest && isset($_POST['ajax']) && $_POST['ajax'] == 'china-calendar-form') {
            $service->userUsedService();
            $model = new ChinaCalendarForm;
            $model->attributes = $_POST['ChinaCalendarForm'];
            $this->performAjaxValidation($model, 'china-calendar-form');
        } else
            $this->render('china', compact('service'));
    }

    /**
     * @sitemap
     */
    public function actionOvulation()
    {
        $service = Service::model()->findByPk(24);
        $this->render('ovulation', compact('service'));
    }

    public function actionBloodUpdate()
    {
        if (isset($_POST['BloodRefreshForm'])) {
            $model = new BloodRefreshForm();
            $model->attributes = $_POST['BloodRefreshForm'];
            $this->performAjaxValidation($model, 'blood-refresh-form');

            $data = $model->CalculateMonthData();
            $gender = $model->GetGender();
            $this->renderPartial('_blood_refresh_result', array(
                'data' => $data,
                'year' => $model->review_year,
                'month' => $model->review_month,
                'model' => $model,
                'gender' => $gender
            ));
            $service = Service::model()->findByPk(22);
            $service->userUsedService();
        }
    }

    public function actionJapanCalc()
    {
        if (isset($_POST['JapanCalendarForm'])) {
            $model = new JapanCalendarForm();
            $model->attributes = $_POST['JapanCalendarForm'];
            $this->performAjaxValidation($model, 'japan-form');

            $data = $model->CalculateData();
            $gender = $model->GetGender();
            $this->renderPartial('_japan_result', array(
                'data' => $data,
                'year' => $model->review_year,
                'month' => $model->review_month,
                'model' => $model,
                'gender' => $gender
            ));
            $service = Service::model()->findByPk(21);
            $service->userUsedService();
        }
    }

    public function actionOvulationCalc()
    {
        if (isset($_POST['OvulationForm'])) {
            $modelForm = new OvulationForm();
            $modelForm->attributes = $_POST['OvulationForm'];
            $this->performAjaxValidation($modelForm, 'ovulation-form');
            $modelForm->validate();

            $data = $modelForm->CalculateData();
            $gender = $modelForm->GetGender();
            $this->renderPartial('ovulation_result', array(
                'data' => $data,
                'model' => $modelForm,
                'gender' => $gender,
                'year' => $modelForm->review_year,
                'month' => $modelForm->review_month,
            ));

            $service = Service::model()->findByPk(24);
            $service->userUsedService();
        }
    }



    public function roundOpacity($op)
    {
        return round($op / 20) * 20;
    }

    public function performAjaxValidation($model, $formName)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] == $formName) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}