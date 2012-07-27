<?php
class ConverterController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
            'units,ac,calculate + ajaxOnly'
        );
    }

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
        $condition = ' (SELECT COUNT(cook__ingredient_units.id) FROM cook__ingredient_units WHERE cook__ingredient_units.ingredient_id = t.id) > 1 ';
        $ingredients = CookIngredient::model()->autoComplete($term, 20, false, true, $condition);
        header('Content-type: application/json');
        echo CJSON::encode($ingredients);
    }

    public function actionCalculate()
    {
        if (isset($_POST['ConverterForm'])) {
            $converter = new CookConverter();
            $result = $converter->convert($_POST['ConverterForm']);

            $result['qty'] = (round($result['qty']) == $result['qty']) ? $result['qty'] : round($result['qty'], 2);
            header('Content-type: application/json');
            echo CJSON::encode($result['qty']);

            UserAction::model()->add(Yii::app()->user->id, UserAction::USER_ACTION_USED_SERVICES, array('service' => 'converter'));
        }
    }
}