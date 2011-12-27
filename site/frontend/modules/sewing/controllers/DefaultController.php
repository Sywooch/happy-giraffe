<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/new2';

    public function actionEmbroideryCost()
    {
        $this->render('embroideryCost');
    }

    public function actionFabricCalculator()
    {
        $this->render('fabricCalculator');
    }

    public function actionThreadCalculation()
    {
        $this->render('threadCalculation');
    }

    public function actionYarnCalculator()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['id'])) {
                $model = new YarnCalcForm();
                $model->LoadYarnProject($_POST['id']);

                echo CJSON::encode(array(
                    'size'=>CHtml::activeDropDownList($model, 'size', YarnProjects::model()->sizes[$model->model->sizes_id], array('id'=>'size')),
                    'gauge'=>CHtml::activeDropDownList($model, 'gauge', YarnProjects::model()->gauges[$model->model->loop_type_id], array('id'=>'gauge'))));
            }
            if (isset($_POST['YarnCalcForm'])) {
                $model = new YarnCalcForm();
                $model->attributes = $_POST['YarnCalcForm'];
                echo $model->GetResult();
            }
        } else
            $this->render('yarnCalculator');
    }

    public function actionLoopCalculator()
    {
        $this->render('loopCalculator');
    }

    /**
     * DEV_METHOD
     */
    public function actionParseSite()
    {
        $url = 'http://www.kudel.ru/calc.php';

        $project = 16;
        $size = 8;
        $gauge = 7;
        $global_size = 1;
        for ($size = 105; $size <= 111; $size++) {
            for ($gauge = 1; $gauge <= 8; $gauge++) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
                curl_setopt($ch, CURLOPT_FAILONERROR, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
                curl_setopt($ch, CURLOPT_TIMEOUT, 3); // times out after 4s
                curl_setopt($ch, CURLOPT_POST, 1); // set POST method
                $gauge_val = 821 + ($global_size - 1) * 8 + $gauge;
                curl_setopt($ch, CURLOPT_POSTFIELDS, "project=$project&size=$size&gauge=$gauge_val&submit=%D0%A0%D0%B0%D1%81%D1%87%D0%B5%D1%82+%D0%BF%D0%BE%D1%82%D1%80%D0%B5%D0%B1%D0%BD%D0%BE%D1%81%D1%82%D0%B8+%D0%BF%D1%80%D1%8F%D0%B6%D0%B8%21"); // add POST fields
                $result = curl_exec($ch); // run the whole process
                curl_close($ch);
                preg_match('/([\d,]+) метров пряжи потребуется/', $result, $matches);
                $value = str_replace(',', '', $matches[1]);
                echo $value . '<br>';
                Yii::app()->db->createCommand()
                    ->insert('yarn', array(
                    'project' => $project,
                    'size' => $global_size,
                    'gauge' => $gauge,
                    'value' => $value,
                ));
                flush();
                sleep(1);
            }
            $global_size++;
        }
    }

}