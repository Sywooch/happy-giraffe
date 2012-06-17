<?php
/**
 * Author: choo
 * Date: 31.05.2012
 */
class RecipeController extends HController
{
    public $counts;
    public $currentType = null;

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + ac, searchByIngredientsResult, advancedSearchResult'
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

    public function actionIndex($type = null)
    {
        $this->layout = '//layouts/recipe';
        $this->currentType = $type;

        $dp = CookRecipe::model()->getByType($type);
        $this->counts = CookRecipe::model()->counts;

        $this->render('index', compact('dp'));
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
            $ingredients = array();
            $recipe->attributes = $_POST['CookRecipe'];
            if ($recipe->isNewRecord)
                $recipe->author_id = Yii::app()->user->id;
            foreach ($_POST['CookRecipeIngredient'] as $i) {
                if (!empty($i['ingredient_id']) || !empty($i['value']) || $i['unit_id'] != CookRecipeIngredient::EMPTY_INGREDIENT_UNIT) {
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

    /**
     * Импорт рецептов
     */
    public function actionImport($content_id)
    {
        $recipe = new CookRecipe;
        $ingredients = array();

        /* IMPORT */
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $content = CommunityContent::model()->full()->findByPk($content_id);

        //title
        $recipe->title = $content->title;

        //bind
        $recipe->content_id = $content_id;

        //text
        $doc = phpQuery::newDocumentXHTML($content->content->text, $charset = 'utf-8');
        $img = pq('img:first');
        $imgSrc = $img->attr('src');
        $img->remove();
        $recipe->text = $doc;

        //image
        preg_match('/\/(\w+)\.(?:\w+)$/', $imgSrc, $matches);
        $fs_name = $matches[1];
        $photo = AlbumPhoto::model()->find('fs_name = :fs_name', array(':fs_name' => $fs_name));
        if ($photo !== null)
            $recipe->photo_id = $photo->id;

        if (isset($_POST['CookRecipe'])) {
            $ingredients = array();
            $recipe->attributes = $_POST['CookRecipe'];
            $recipe->author_id = Yii::app()->user->id;
            foreach ($_POST['CookRecipeIngredient'] as $i) {
                if (!empty($i['ingredient_id']) || !empty($i['value']) || $i['unit_id'] != CookRecipeIngredient::EMPTY_INGREDIENT_UNIT) {
                    $ingredient = new CookRecipeIngredient;
                    $ingredient->attributes = $i;
                    $ingredient->recipe_id = $recipe->id;
                    $ingredients[] = $ingredient;
                }
            }
            $recipe->ingredients = $ingredients;
            if ($recipe->withRelated->save(true, array('ingredients'))) {
                $content->update(array('removed' => 1));
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
        $this->layout = '//layouts/recipe';

        $recipe = CookRecipe::model()->with('photo', 'attachPhotos', 'cuisine', 'ingredients.ingredient', 'ingredients.unit')->findByPk($id);
        if ($recipe === null)
            throw new CHttpException(404, 'Такого рецепта не существует');

        $this->counts = CookRecipe::model()->counts;
        $this->currentType = $recipe->type;

        $this->render('view', compact('recipe'));
    }

    public function actionSearch($type = null, $text = false)
    {
        $this->layout = '//layouts/recipe';
        $this->currentType = $type;
        $text = urldecode($text);

        $pages = new CPagination();
        $pages->pageSize = 100000;

        $criteria = new stdClass();
        $criteria->from = 'recipe';
        $criteria->select = '*';
        $criteria->paginator = $pages;
        $criteria->query = $text;

        $resIterator = CookRecipe::model()->getSearchResult($criteria);

        $allSearch = Yii::app()->search->select('*')->from('recipe')->where($criteria->query)->limit(0, 100000)->searchRaw();
        $this->counts = CookRecipe::model()->getSearchResultCounts($allSearch);
        $allCount = $this->counts[0];

        $dataProvider = new CArrayDataProvider($resIterator, array(
            'keyField' => 'id',
            'pagination' => array('pageSize' => 10000),
        ));

        $criteria = new CDbCriteria;
        $this->render('search', compact('dataProvider', 'criteria', 'text', 'allCount', 'type'));
    }

    public function actionSearchByIngredients()
    {
        $this->render('searchByIngredients');
    }

    public function actionSearchByIngredientsResult()
    {
        $ingredients = Yii::app()->request->getQuery('ingredients', array());
        $type = Yii::app()->request->getQuery('type', null);
        $ingredients = array_filter($ingredients);
        $recipes = CookRecipe::model()->findByIngredients($ingredients, $type);
        $this->renderPartial('searchByIngredientsResult', compact('recipes', 'type'));
    }

    public function actionAdvancedSearch()
    {
        $cuisines = CookCuisine::model()->findAll();
        $this->render('advancedSearch', compact('cuisines'));
    }

    public function actionAdvancedSearchResult()
    {
        foreach (array('cuisine_id', 'type', 'method', 'preparation_duration', 'cooking_duration') as $var) {
            $$var = ($temp = Yii::app()->request->getQuery($var, '')) == '' ? null : $temp;
        }
        foreach (array('lowCal', 'lowFat', 'forDiabetics1', 'forDiabetics2') as $var) {
            $$var = (bool)Yii::app()->request->getQuery($var);
        }
        $forDiabetics = $forDiabetics1 || $forDiabetics2;

        $recipes = CookRecipe::model()->findAdvanced($cuisine_id, $type, $method, $preparation_duration, $cooking_duration, $lowFat, $lowCal, $forDiabetics);
        $this->renderPartial('advancedSearchResult', compact('recipes'));
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
