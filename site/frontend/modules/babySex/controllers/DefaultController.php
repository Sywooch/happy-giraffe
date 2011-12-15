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

    public function actionOvulation()
    {
        $this->render('ovulation');
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

    public function actionParse()
    {
        $str = '2 1 2 1 1 1 1 1 1 1 1 1
        1 2 1 2 2 1 1 2 1 1 2 2
        2 1 2 1 1 1 1 1 1 2 1 1
        1 2 2 2 2 2 2 2 2 2 2 2
        2 1 1 2 1 2 2 1 2 2 2 2
        1 1 1 2 1 1 2 2 2 1 1 2
        1 2 2 1 1 2 1 2 1 1 2 1
        2 1 2 1 2 1 2 1 2 1 1 1
        1 1 1 1 1 2 1 2 2 1 2 2
        2 2 1 1 2 1 2 2 1 2 1 1
        1 1 1 2 2 1 2 1 2 2 1 2
        2 1 2 2 1 2 2 1 2 1 2 2
        1 1 2 1 2 1 1 1 1 1 1 1
        1 1 1 1 2 2 1 2 1 2 2 2
        1 2 2 1 2 1 1 2 1 1 2 1
        2 1 1 2 2 1 2 1 2 1 1 2
        1 1 2 2 1 2 1 1 2 1 2 2
        1 2 1 2 1 2 1 2 1 1 2 1
        1 2 1 1 1 2 1 1 2 2 2 2
        2 2 1 2 2 2 1 2 2 1 1 1
        1 1 2 2 1 2 2 1 2 2 1 2
        2 2 1 2 2 2 1 2 1 1 2 1
        1 1 1 2 1 2 1 2 1 2 2 1
        2 2 1 2 1 1 2 2 1 2 1 2
        1 2 2 1 1 1 1 1 2 1 2 1
        2 1 2 2 1 1 1 2 2 2 1 1
        1 2 2 2 1 2 1 1 2 1 2 1
        2 1 2 1 2 2 1 2 1 2 1 2';
        $data = explode("\n", $str);
        foreach ($data as $row) {
            $row_data = str_replace(" ", ",", trim($row));
            echo 'new Array(' . $row_data . '),' . '<br>';
        }
    }

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

    public function actionOvulationCalc()
    {
        if (isset($_POST['OvulationForm'])) {
            $modelForm = new OvulationForm();
            $modelForm->attributes = $_POST['OvulationForm'];
            if (!$modelForm->validate())
                Yii::app()->end();

            $data = $modelForm->CalculateData();
            $this->renderPartial('ovulation_result', array(
                'data' => $data,
                'model' => $modelForm,
            ));
        }
    }
}