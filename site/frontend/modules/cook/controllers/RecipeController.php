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
        $ingredients = CookRecipeIngredient::model()->getEmptyModel(20);

        if (isset($_POST['CookRecipe'], $_POST['CookRecipeIngredient'])) {
            $transaction = $recipe->dbConnection->beginTransaction();
            try {
                $recipe->attributes = $_POST['CookRecipe'];
                $recipe->author_id = Yii::app()->user->id;
                $recipe->save();
                foreach ($_POST['CookRecipeIngredient'] as $i) {
                    $ingredient = new CookRecipeIngredient;
                    $ingredient->attributes = $i;
                    $ingredient->recipe_id = $recipe->id;
                    $ingredient->save();
                    $ingredients[] = $ingredient;
                }
                $transaction->commit();
                $this->redirect('cook/recipe/add');
            } catch(Exception $e)
            {
                $transaction->rollBack();
            }
        }

        $cuisines = CookCuisine::model()->findAll();
        $units = CookUnit::model()->findAll();
        $this->render('_form', compact('recipe', 'ingredients', 'cuisines', 'units'));
    }

    public function actionAc($term)
    {
        $criteria = new CDbCriteria(array(
            'select' => 'id, title',
            'with' => array('units', 'unit'),
        ));
        $criteria->compare('t.title', $term, true);

        $_ingredients = array();
        $ingredients = CookIngredient::model()->findAll($criteria);
        foreach ($ingredients as $i) {
            $unit = array('id' => $i->unit->id, 'title' => $i->unit->title);
            $units = array();
            foreach ($i->availableUnits as $u) {
                $units[] = array('id' => $u->id, 'title' => $u->title);
            }
            $ingredient = array('label' => $i->title, 'value' => $i->title, 'id' => $i->id, 'units' => $units, 'unit' => $unit);
            $_ingredients[] = $ingredient;
        }

        echo CJSON::encode($_ingredients);
    }
}
