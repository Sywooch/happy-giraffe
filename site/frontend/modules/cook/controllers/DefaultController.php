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
}