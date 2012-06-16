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
        $ingredients = Yii::app()->db->createCommand()->select('id, unit_id, title, title AS value, title AS label')->from('cook__ingredients')
            ->where('title LIKE :term AND (SELECT COUNT(cook__ingredient_units.id) FROM cook__ingredient_units WHERE cook__ingredient_units.ingredient_id = cook__ingredients.id) > 1', array(':term' => $term . '%'))->order('title')
            ->limit(20)->queryAll();
        if (count($ingredients) < 20) {
            $ingredients2 = Yii::app()->db->createCommand()->select('id, unit_id, title, title AS value, title AS label')->from('cook__ingredients')
                ->where('title LIKE :term AND (SELECT COUNT(cook__ingredient_units.id) FROM cook__ingredient_units WHERE cook__ingredient_units.ingredient_id = cook__ingredients.id) > 1', array(':term' => $term . '%'))->order('title')
                ->limit(20 - count($ingredients))->queryAll();
            if (count($ingredients2)) {
                $ingredient_keys = array();
                if (count($ingredients)) {
                    foreach ($ingredients as $ingredient) {
                        $ingredient_keys[] = $ingredient['id'];
                    }
                }
                foreach ($ingredients2 as $ingredient) {
                    if (!in_array($ingredient['id'], $ingredient_keys)) {
                        $ingredients[] = $ingredient;
                    }
                }
            }
        }

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