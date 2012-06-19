<?php
class ConverterController extends HController
{

    //public $layout = '//layouts/new';

    public function actionIndex()
    {
        $this->pageTitle = 'Калькулятор мер и весов';

        $this->render('index', array(
            'model' => new ConverterForm()
        ));
    }

    public function actionUnits()
    {
        $ingredient = CookIngredient::model()->findByPk($_POST['id']);
        header('Content-type: application/json');
        echo CJSON::encode($ingredient->getUnitsIds());
    }

    public function actionAc($term)
    {
        $ingredients = CookIngredient::model()->autoComplete($term, 2, false, true);
        header('Content-type: application/json');
        echo CJSON::encode($ingredients);
    }

    public function actionCalculate()
    {
        $form = new ConverterForm();

        if (isset($_POST['ajax']) and $_POST['ajax'] == 'converter-form') {
            $form->attributes = $_POST['ConverterForm'];
//            echo CActiveForm::validate($form);
            echo '[]';
            Yii::app()->end();
        } elseif (isset($_POST['ConverterForm'])) {
            $converter = new CookConverter();
            $result = $converter->convert($_POST['ConverterForm']);
            header('Content-type: application/json');
            $result['qty'] = (round($result['qty']) == $result['qty']) ? $result['qty'] : round($result['qty'], 2);
            echo CJSON::encode($result['qty']);
        }
    }
}