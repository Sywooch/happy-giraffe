<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/new';

	public function actionIndex()
	{
        $model = new PlacentaThicknessForm;
		$this->render('index',array('model'=>$model));
	}

    public function actionCalculate(){
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_POST['PlacentaThicknessForm'])){
                $model = new PlacentaThicknessForm;
                $model->attributes = $_POST['PlacentaThicknessForm'];
                if (!$model->validate()){
//                    echo CActiveForm::validate($model);
                    Yii::app()->end();
                }
                $placentaThickness = PlacentaThickness::model()->cache(3600)->find(array(
                    'condition'=>'week='.$model->week,
                    'select'=>array('min','avg','max')
                ));
                $this->renderPartial('result',array(
                    'placentaThickness'=>$placentaThickness,
                    'model'=>$model
                ));
            }
        }else
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

    }
}