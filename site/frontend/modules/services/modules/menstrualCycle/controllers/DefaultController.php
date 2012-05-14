<?php

class DefaultController extends HController
{
    public $layout = '//layouts/new';

    public function filters()
    {
        return array(
            'ajaxOnly + calculate',
        );
    }

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Менструальный цикл - составь свой женский календарь';

        $this->render('index');
    }

    public function actionCalculate()
    {
        if (isset($_POST['MenstrualCycleForm'])) {
            $modelForm = new MenstrualCycleForm();
            $modelForm->attributes = $_POST['MenstrualCycleForm'];
            $this->performAjaxValidation($modelForm);

            $modelForm->validate();
            $data = $modelForm->CalculateData();
            $this->renderPartial('data', array(
                'data' => $data,
                'model' => $modelForm,
                'next_data' => $modelForm->CalculateDataForNextMonth()
            ));
        }
    }

    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'menstrual-cycle-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * DEV_METHOD
     */
    /*public function actionParse()
    {
        $str =
            <<<EOD
            21 7 0 3 1 3 5 2
21 6 0 3 1 3 6 2
21 5 0 4 1 3 6 2
21 4 0 5 1 3 6 2
21 3 1 5 1 3 6 2
22 7 0 4 1 3 5 2
22 6 0 4 1 3 6 2
22 5 0 5 1 3 6 2
22 4 1 5 1 3 6 2
22 3 2 5 1 3 6 2
23 7 0 3 1 3 7 2
23 6 0 4 1 3 7 2
23 5 0 5 1 3 7 2
23 4 1 5 1 3 7 2
23 3 2 5 1 3 7 2
24 7 0 4 1 3 7 2
24 6 0 5 1 3 7 2
24 5 1 5 1 3 7 2
24 4 2 5 1 3 7 2
24 3 3 5 1 3 7 2
25 7 0 4 1 3 8 2
25 6 0 5 1 3 8 2
25 5 1 5 1 3 8 2
25 4 2 5 1 3 8 2
25 3 3 5 1 3 8 2
26 7 0 5 1 3 8 2
26 6 1 5 1 3 8 2
26 5 2 5 1 3 8 2
26 4 3 5 1 3 8 2
26 3 4 5 1 3 8 2
27 7 0 5 1 3 8 3
27 6 1 5 1 3 8 3
27 5 2 5 1 3 8 3
27 4 3 5 1 3 8 3
27 3 4 5 1 3 8 3
28 7 1 5 1 3 8 3
28 6 2 5 1 3 8 3
28 5 3 5 1 3 8 3
28 4 4 5 1 3 8 3
28 3 5 5 1 3 8 3
29 7 1 5 1 3 8 4
29 6 2 5 1 3 8 4
29 5 3 5 1 3 8 4
29 4 4 5 1 3 8 4
29 3 5 5 1 3 8 4
30 7 2 5 1 3 9 3
30 6 3 5 1 3 9 3
30 5 4 5 1 3 9 3
30 4 5 5 1 3 9 3
30 3 6 5 1 3 9 3
31 7 2 5 1 3 9 4
31 6 3 5 1 3 9 4
31 5 4 5 1 3 9 4
31 4 5 5 1 3 9 4
31 3 6 5 1 3 9 4
32 7 3 5 1 3 9 4
32 6 4 5 1 3 9 4
32 5 5 5 1 3 9 4
32 4 6 5 1 3 9 4
32 3 7 5 1 3 9 4
33 7 3 5 1 3 10 4
33 6 4 5 1 3 10 4
33 5 5 5 1 3 10 4
33 4 6 5 1 3 10 4
33 3 7 5 1 3 10 4
34 7 4 5 1 3 10 4
34 6 5 5 1 3 10 4
34 5 6 5 1 3 10 4
34 4 7 5 1 3 10 4
34 3 8 5 1 3 10 4
35 7 4 5 1 3 10 5
35 6 5 5 1 3 10 5
35 5 6 5 1 3 10 5
35 4 7 5 1 3 10 5
35 3 8 5 1 3 10 5
EOD;
        $data = explode("\n", $str);
        foreach ($data as $row) {
            $row_data = explode(" ", $row);
            var_dump($row_data);
            $model = new MenstrualCycle();
            $model->cycle = $row_data[0];
            $model->menstruation = $row_data[1];
            $model->safety_sex = $row_data[2];
            $model->ovulation_probable = $row_data[3];
            $model->ovulation_most_probable = $row_data[4];
            $model->ovulation_can = $row_data[5];
            $model->pms = $row_data[6];
            //            $model->save();
        }
    }
*/
}