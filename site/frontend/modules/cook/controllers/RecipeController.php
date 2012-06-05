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
        $ingredients = array();

        if (isset($_POST['CookRecipe'])) {
            $recipe->attributes = $_POST['CookRecipe'];
            $recipe->author_id = Yii::app()->user->id;
            foreach ($_POST['CookRecipeIngredient'] as $i) {
                if (! empty($i['ingredient_id']) || ! empty($i['value']) || $i['unit_id'] != CookRecipeIngredient::EMPTY_INGREDIENT_UNIT) {
                    $ingredient = new CookRecipeIngredient;
                    $ingredient->attributes = $i;
                    $ingredient->recipe_id = $recipe->id;
                    $ingredients[] = $ingredient;
                }
            }
            $recipe->ingredients = $ingredients;
            $recipe->withRelated->save(true, array('ingredients'));
        }

        if (empty($ingredients))
            $ingredients = CookRecipeIngredient::model()->getEmptyModel(3);

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
