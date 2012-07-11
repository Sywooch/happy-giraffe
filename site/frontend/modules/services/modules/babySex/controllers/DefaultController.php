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
        $this->pageTitle = 'Определение пола ребенка';
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $this->render('index');
    }

    /**
     * @sitemap
     */
    public function actionBloodRefresh()
    {
        $this->pageTitle = 'Пол ребенка по обновлению крови';

        $this->render('blood_refresh');
    }

    /**
     * @sitemap
     */
    public function actionJapan()
    {
        $this->pageTitle = 'Будущий пол ребенка - японский метод';

        $this->render('japan');
    }

    /**
     * @sitemap
     */
    public function actionBlood()
    {
        $this->pageTitle = 'Пол ребенка по группе крови';

        $this->render('blood_group');
    }

    /**
     * @sitemap
     */
    public function actionChina()
    {
        $this->pageTitle = 'Пол ребенка по китайской таблице. Китайский метод определения пола ребенка';

        if (Yii::app()->request->isAjaxRequest){
            $model = new ChinaCalendarForm;
            $model->attributes = $_POST['ChinaCalendarForm'];
            $this->performAjaxValidation($model, 'china-calendar-form');
        }else
            $this->render('china');
    }

    /**
     * @sitemap
     */
    public function actionOvulation()
    {
        $this->pageTitle = 'Пол ребенка по овуляции';

        $this->render('ovulation');
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
        }
    }

    /**
     * DEV_METHOD
     */
    /*public function actionParse()
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
*/
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
                'gender'=>$gender,
                'year' => $modelForm->review_year,
                'month' => $modelForm->review_month,
            ));
        }
    }

    public function roundOpacity($op)
    {
        return round($op/20)*20;
    }

    public function performAjaxValidation($model, $formName)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] == $formName){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}