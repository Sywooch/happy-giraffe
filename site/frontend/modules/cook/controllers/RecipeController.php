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
            'ajaxOnly + ac, searchResult'
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions' => array('form'),
                'users' => array('?'),
            ),
        );
    }

    public function actionForm($id = null)
    {
        if ($id === null) {
            $recipe = new CookRecipe;
            $ingredients = array();
        } else {
            $recipe = CookRecipe::model()->with('ingredients.unit', 'ingredients.ingredient.availableUnits')->findByPk($id);
            $ingredients = $recipe->ingredients;
        }

        if (isset($_POST['CookRecipe'])) {
            $recipe->attributes = $_POST['CookRecipe'];
            if ($recipe->isNewRecord)
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
            if ($recipe->withRelated->save(true, array('ingredients'))) {
                $this->redirect(array('/cook/recipe/view', 'id' => $recipe->id));
            }
        }

        if (empty($ingredients))
            $ingredients = CookRecipeIngredient::model()->getEmptyModel(3);

        $cuisines = CookCuisine::model()->findAll();
        $units = CookUnit::model()->findAll();
        $this->render('form', compact('recipe', 'ingredients', 'cuisines', 'units'));
    }

    public function actionView($id)
    {
        $recipe = CookRecipe::model()->with('photo', 'cuisine', 'ingredients.ingredient', 'ingredients.unit')->findByPk($id);
        if ($recipe === null)
            throw new CHttpException(404, 'Такого рецепта не существует');

        $this->render('view', compact('recipe'));
    }


    public function actionSearch()
    {
        $this->render('search');
    }

    public function actionSearchResult()
    {
        $ingredients = Yii::app()->request->getQuery('ingredients', array());
        $type = Yii::app()->request->getQuery('type', null);
        $ingredients = array_filter($ingredients);
        $recipes = CookRecipe::model()->findByIngredients($ingredients, $type);
        $this->renderPartial('searchResult', compact('recipes', 'type'));
    }

    public function actionAc($term)
    {
        $ingredients = CookIngredient::model()->findByName($term, array(
            'select' => 'id, title',
            'with' => array('units', 'unit'),
        ));

        $_ingredients = array();
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
