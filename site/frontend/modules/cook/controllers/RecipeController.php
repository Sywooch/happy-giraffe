<?php
/**
 * Author: choo
 * Date: 31.05.2012
 */
class RecipeController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions' => array('add'),
                'users' => array('?'),
            ),
        );
    }

    public function actionAdd()
    {
        $recipe = new CookRecipe;

        if (isset($_POST['CookRecipe'])) {
            $recipe->attributes = $_POST['CookRecipe'];
            $recipe->author_id = Yii::app()->user->id;
            if ($recipe->save()) {
                echo 'ok';
                Yii::app()->end();
            }
        }

        $cuisines = CookCuisine::model()->findAll();
        $this->render('_form', compact('recipe', 'cuisines'));
    }
}
