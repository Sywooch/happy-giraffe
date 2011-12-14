<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/new';

    public function filters()
    {
        return array(
            'ajaxOnly + bloodUpdate, japanCalc',
        );
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionBloodRefresh()
    {
        $this->render('blood_refresh');
    }

    public function actionJapan()
    {
        $this->render('japan');
    }

    public function actionBlood()
    {
        $this->render('blood_group');
    }

    public function actionChina()
    {
        $this->render('china');
    }

    public function actionBloodUpdate()
    {
        if (isset($_POST['BloodRefreshForm'])) {
            $model = new BloodRefreshForm();
            $model->attributes = $_POST['BloodRefreshForm'];
            if (!$model->validate())
                Yii::app()->end();

            $data = $model->CalculateMonthData();
            $gender = $model->GetGender();
            $this->renderPartial('_blood_refresh_result', array(
                'data' => $data,
                'year' => $model->review_year,
                'month' => $model->review_month,
                'model' => $model,
                'gender' => $gender
            ));
        }
    }

//    public function actionChina()
//    {
//        if (isset($_POST['ChinaCalendarForm'])) {
//            $model = new ChinaCalendarForm();
//            $model->attributes = $_POST['ChinaCalendarForm'];
//            if (!$model->validate())
//                Yii::app()->end();
//
//            $data = $model->CalculateData();
//            $this->renderPartial('_china_result', array(
//                'data' => $data,
//            ));
//        }
//    }

    public function actionJapanCalc()
    {
        if (isset($_POST['JapanCalendarForm'])) {
            $model = new JapanCalendarForm();
            $model->attributes = $_POST['JapanCalendarForm'];
            if (!$model->validate())
                Yii::app()->end();

            $data = $model->CalculateData();
            $gender = $model->GetGender();
            $this->renderPartial('_japan_result', array(
                'data' => $data,
                'year' => $model->review_year,
                'month' => $model->review_month,
                'model' => $model,
                'gender' => $gender
            ));
        }
    }
}