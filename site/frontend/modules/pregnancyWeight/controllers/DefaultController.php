<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/new';

    public function filters()
    {
        return array(
            'ajaxOnly + GetData',
        );
    }

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Вес при беременности. Прибавка веса во время беременности по неделям';

        $this->render('index');
    }

    public function actionGetData()
    {
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
}