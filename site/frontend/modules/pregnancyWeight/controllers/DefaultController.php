<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/new';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionGetData()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['PregnantParamsForm'])) {
                $model = new PregnantParamsForm();
                $model->attributes = $_POST['PregnantParamsForm'];
                if (!$model->validate())
                    Yii::app()->end();

                $recommend_gain = PregnancyWeight::GetWeightGainByWeekAndBMI($model->week, $model->bmi);
                $recommend_weight = $model->weight_before + (float)$recommend_gain;
                $data = PregnancyWeight::GetWeightArray($model->weight_before, $model->bmi);
                $gain = PregnancyWeight::GetWeightArrayFromCache($model->bmi);

                $this->renderPartial('data', array(
                    'recommend_weight' => $recommend_weight,
                    'model' => $model,
                    'data' => $data,
                    'gain' => $gain[$model->week]
                ));
            }
        }
        else
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
    }
}