<?php

class DefaultController extends HController
{
    public $layout = '//layouts/new2';

    /**
     * @sitemap
     */
    public function actionEmbroideryCost()
    {
        $this->pageTitle = 'Расчёт стоимости вышивки';

        $model = new EmbroideryCostForm();
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['EmbroideryCostForm'])) {
                $model->attributes = $_POST['EmbroideryCostForm'];
                $this->performAjaxValidation($model, 'embroideryCost-form');
            }
        } else
            $this->render('embroideryCost');
    }

    /**
     * @sitemap
     */
    public function actionFabricCalculator()
    {
        $this->pageTitle = 'Сколько ткани нужно? Рассчитай!';

        $model = new FabricCalculatorForm1();
        $model2 = new FabricCalculatorForm2();
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['FabricCalculatorForm1'])) {
                $model->attributes = $_POST['FabricCalculatorForm1'];
                $this->performAjaxValidation($model, 'fabric-calculator-form1');
            } elseif (isset($_POST['FabricCalculatorForm2'])) {
                $model2->attributes = $_POST['FabricCalculatorForm2'];
                $this->performAjaxValidation($model2, 'fabric-calculator-form2');
            }
        } else
            $this->render('fabricCalculator');
    }

    /**
     * @sitemap
     */
    public function actionThreadCalculation()
    {
        $this->pageTitle = 'Нитки для вышивания. Сколько нужно?';

        $model = new ThreadCalculationForm();
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['ThreadCalculationForm'])) {
                $service = Service::model()->findByPk(12);
                $service->userUsedService();

                $model->attributes = $_POST['ThreadCalculationForm'];
                $this->performAjaxValidation($model, 'threads-calculator-form');
            }
        } else
            $this->render('threadCalculation');
    }

    /**
     * @sitemap
     */
    public function actionLoopCalculator()
    {
        $this->pageTitle = 'Сколько набирать петель';

        $model = new LoopCalculationForm();
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['LoopCalculationForm'])) {
                $model->attributes = $_POST['LoopCalculationForm'];
                $this->performAjaxValidation($model, 'loop-calculator-form');
            }
        } else
            $this->render('loopCalculator');
    }

    /**
     * @sitemap
     */
    public function actionYarnCalculator()
    {
        $this->pageTitle = 'Сколько нужно пряжи';

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['id'])) {
                $model = new YarnCalcForm();
                $model->LoadYarnProject($_POST['id']);

                echo CJSON::encode(array(
                    'size' => CHtml::listOptions('', array(''=>'Выберите размер')+YarnProjects::model()->sizes[$model->model->sizes_id], $null),
                    'gauge' => CHtml::listOptions(' ', array(''=>'Выберите количество петель')+YarnProjects::model()->gauges[$model->model->loop_type_id], $null)
                ));
            }
            if (isset($_POST['YarnCalcForm'])) {
                $service = Service::model()->findByPk(13);
                $service->userUsedService();

                $model = new YarnCalcForm();
                $model->attributes = $_POST['YarnCalcForm'];
                $this->performAjaxValidation($model, 'yarn-calculator-form');

                echo $model->GetResult();
            }
        } else
            $this->render('yarnCalculator');
    }

    public function performAjaxValidation($model, $formName)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] == $formName) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * DEV_METHOD
     */
    /*public function actionParseSite()
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
    }*/

}