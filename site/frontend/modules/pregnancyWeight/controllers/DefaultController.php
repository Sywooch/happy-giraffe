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

                $model->CalculateData();

                $this->renderPartial('data', array(
                    'model' => $model,
                ));
            }
        }
        else
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
    }
}