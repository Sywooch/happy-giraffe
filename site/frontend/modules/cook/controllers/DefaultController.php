<?php

class DefaultController extends HController
{

    //public $layout = '//layouts/new';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionTest()
    {
        $result = array();

        if (isset($_POST['TestForm'])) {
            $calorisator = new CookCalorisator();
            $calorisator->RecipeIngredients = $_POST['TestForm']['recipeIngredients'];
            $result = array(
                'substrings' => $calorisator->RecipeSubstrings,
                'ingredients' => $calorisator->ingredients
            );
        }

        $this->render('test', array('model' => new TestForm(), 'result' => $result));
    }

    public function actionTest2()
    {

        $converter = new CookConverter();

        $data = array(
            array(
                'ingredient_id' => 338,
                'unit_id' => 1,
                'value' => 50
            ),
            array(
                'ingredient_id' => 371,
                'unit_id' => 14,
                'value' => 2
            )
        );

        $result = $converter->calculateNutritionals($data);

        echo '<pre>' . print_r($result, true) . '</pre>';

        Yii::app()->end();
    }

    public function actionTest3(){
        $recipe = CookRecipe::model()->findByPk(1);
        echo '<pre>'.print_r($recipe->nutritionals, true).'</pre>';
    }
}