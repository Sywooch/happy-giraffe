<?php
/**
 * Author: choo
 * Date: 31.05.2012
 */
class RecipeController extends HController
{
    public $counts;
    public $currentType = null;
    public $modelName;
    public $section;

    public function filters()
    {
        return array(
            'accessControl',
            //'ajaxOnly + ac, searchByIngredientsResult, advancedSearchResult'
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

    protected function beforeAction($action)
    {
        if (isset($this->actionParams['section']) && isset(CookRecipe::model()->sectionsMap[$this->actionParams['section']])) {
            $this->modelName = CookRecipe::model()->sectionsMap[$this->actionParams['section']];
            $this->section = $this->actionParams['section'];
        } else {
            $this->modelName = CookRecipe::model()->sectionsMap[CookRecipe::COOK_DEFAULT_SECTION];
            $this->section = null;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex($type = null, $section = null)
    {
        $this->pageTitle = 'Рецепты';
        $this->layout = '//layouts/recipe';
        $this->currentType = $type;

        $dp = CActiveRecord::model($this->modelName)->getByType($type);
        $this->counts = CActiveRecord::model($this->modelName)->counts;

        $this->render('index', compact('dp'));
    }

    public function actionForm($id = null)
    {
        $this->pageTitle = 'Добавить рецепт';

        if ($id === null) {
            $recipe = new $this->modelName;
            $ingredients = array();
        } else {
//            $recipe = CActiveRecord::model($this->modelName)->with('ingredients.unit', 'ingredients.ingredient.availableUnits')->findByPk($id);
            $recipe = CActiveRecord::model($this->modelName)->findByPk($id);
            if ($recipe === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $ingredients = $recipe->ingredients;
        }

        if (isset($_POST[$this->modelName])) {
            $ingredients = array();
            $recipe->attributes = $_POST[$this->modelName];
            if ($recipe->isNewRecord)
                $recipe->author_id = Yii::app()->user->id;
            if (isset($_POST['CookRecipeIngredient']))
                foreach ($_POST['CookRecipeIngredient'] as $i) {
                    if (!empty($i['ingredient_id']) || !empty($i['value']) || $i['unit_id'] != CookRecipeIngredient::EMPTY_INGREDIENT_UNIT) {
                        $ingredient = new CookRecipeIngredient;
                        $ingredient->attributes = $i;
                        $ingredient->setValue();
                        $ingredient->recipe_id = $recipe->id;
                        $ingredients[] = $ingredient;
                    }
                }
            $recipe->ingredients = $ingredients;
            if ($recipe->withRelated->save(true, array('ingredients'))) {
                $this->redirect(array('/cook/recipe/view', 'id' => $recipe->id, 'section' => $this->section));
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
        $content = CommunityContent::model()->full()->findByPk($content_id);
        if ($content === null)
            throw new CHttpException(404, 'Статья не существует или уже перенесена в рецепты');

        $recipe = new CookRecipe;
        $ingredients = array();

        Yii::import('site.frontend.extensions.phpQuery.phpQuery');


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
        preg_match('/\/([\w\.]+)$/', $imgSrc, $matches);
        if ($matches) {
            $fs_name = $matches[1];
            $photo = AlbumPhoto::model()->find('fs_name = :fs_name', array(':fs_name' => $fs_name));
            if ($photo !== null)
                $recipe->photo_id = $photo->id;
        }

        if (isset($_POST['CookRecipe'])) {
            $ingredients = array();
            $recipe->attributes = $_POST['CookRecipe'];
            $recipe->author_id = $content->author_id;
            if (isset($_POST['CookRecipeIngredient']))
                foreach ($_POST['CookRecipeIngredient'] as $i) {
                    if (!empty($i['ingredient_id']) || !empty($i['value']) || $i['unit_id'] != CookRecipeIngredient::EMPTY_INGREDIENT_UNIT) {
                        $ingredient = new CookRecipeIngredient;
                        $ingredient->attributes = $i;
                        $ingredient->setValue();
                        $ingredient->recipe_id = $recipe->id;
                        $ingredients[] = $ingredient;
                    }
                }
            $recipe->ingredients = $ingredients;
            if ($recipe->withRelated->save(true, array('ingredients'))) {
                $content->removed = 1;
                $content->update(array('removed'));
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
     * @sitemap dataSource=getContentUrls
     */
    public function actionView($id, $section, $lastPage = null, $ajax = null)
    {
        $recipe = CActiveRecord::model($this->modelName)->with('photo', 'attachPhotos', 'cuisine', 'ingredients.ingredient', 'ingredients.unit')->findByPk($id);
        if ($recipe === null)
            throw new CHttpException(404, 'Такого рецепта не существует');

        $this->counts = CActiveRecord::model($this->modelName)->counts;
        $this->currentType = $recipe->type;
        $this->layout = '//layouts/recipe';
        $this->pageTitle = $recipe->title;

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
        $this->pageTitle = 'Поиск рецептов по ингредиентам';
        $this->render('searchByIngredients');
    }

    public function actionSearchByIngredientsResult()
    {
        $ingredients = Yii::app()->request->getQuery('ingredients', array());
        $type = Yii::app()->request->getQuery('type', null);
        $ingredients = array_filter($ingredients);
        $recipes = CActiveRecord::model($this->modelName)->findByIngredients($ingredients, $type);
        $this->renderPartial('searchByIngredientsResult', compact('recipes', 'type'));
    }

    public function actionAdvancedSearch()
    {
        $this->pageTitle = 'Расширенный поиск рецептов';
        $cuisines = CookCuisine::model()->findAll();
        $this->render('advancedSearch', compact('cuisines'));
    }

    public function actionAdvancedSearchResult()
    {
        foreach (array('cuisine_id', 'type', 'preparation_duration', 'cooking_duration') as $var) {
            $$var = ($temp = Yii::app()->request->getQuery($var, '')) == '' ? null : $temp;
        }
        foreach (array('lowCal', 'lowFat', 'forDiabetics1', 'forDiabetics2') as $var) {
            $$var = (bool)Yii::app()->request->getQuery($var);
        }
        $forDiabetics = $forDiabetics1 || $forDiabetics2;

        $recipes = CActiveRecord::model($this->modelName)->findAdvanced($cuisine_id, $type, $preparation_duration, $cooking_duration, $lowFat, $lowCal, $forDiabetics);
        $this->renderPartial('advancedSearchResult', compact('recipes'));
    }

    public function actionAcOld($term)
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

    public function actionAc($term)
    {
        $ingredients = CookIngredient::model()->autoComplete($term, 10, false, true);
        echo CJSON::encode($ingredients);
    }

    public function getContentUrls()
    {
        $models = Yii::app()->db->createCommand()
            ->select('id, created, updated')
            ->from('cook__recipes')
            ->queryAll();
        foreach ($models as $model) {
            $data[] = array(
                'params' => array(
                    'id' => $model['id'],
                ),
                'priority' => 0.5,
                'changefreq' => 'daily',
                'lastmod' => ($model['updated'] === null) ? $model['created'] : $model['updated'],
            );
        }
        return $data;
    }

    public function actionFeed()
    {
        header("Content-type: text/xml; charset=utf-8");
        $feed = Yii::app()->cache->get('recipesFeed');
        if ($feed === false) {
            $recipes = CookRecipe::model()->with('cuisine', 'author', 'ingredients.ingredient', 'ingredients.unit')->findAll(array('order' => 'created DESC'));

            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><entities/>');

            foreach ($recipes as $r) {
                if (empty($r->ingredients))
                    break;

                $recipe = $xml->addChild('recipe');
                $recipe->addChild('name', $r->title);
                $recipe->addChild('url', $r->getUrl(false, true));
                $recipe->addChild('type', $r->typeString);
                if ($r->cuisine !== null) {
                    $recipe->addChild('cuisine-type', $r->cuisine->title . ' кухня');
                }
                $recipe->addChild('author', $r->author->fullName);

                foreach ($r->ingredients as $i) {
                    $ingredient = $recipe->addChild('ingredient');
                    switch ($i->unit->type) {
                        case 'qty':
                            $ingredient->addChild('name', HDate::GenerateNoun(array($i->unit->title, $i->unit->title2, $i->unit->title3), $i->value));
                            $ingredient->addChild('quantity', $i->display_value);
                            break;
                        case 'undefined':
                            $ingredient->addChild('name', $i->title . ' ' . $i->unit->title);
                            break;
                        default:
                            $ingredient->addChild('name', $i->title);
                            $ingredient->addChild('type', HDate::GenerateNoun(array($i->unit->title, $i->unit->title2, $i->unit->title3), $i->value));
                            $ingredient->addChild('value', $i->display_value);
                    }
                }

                foreach ($r->nutritionals['total']['nutritionals'] as $id => $value) {
                    $nutrition = $recipe->addChild('nutrition');
                    $nutrition->addChild('type', CookNutritional::model()->findByPk($id)->title);
                    $nutrition->addChild('value', $value);
                }

                $recipe->addChild('instructions', html_entity_decode(strip_tags($r->text), ENT_COMPAT, 'utf-8'));
                $recipe->addChild('calorie', $r->nutritionals['total']['nutritionals'][1] . ' ккал');
                $recipe->addChild('weight', $r->nutritionals['total']['weight'] . ' г');
                if ($r->mainPhoto !== null) {
                    $recipe->addChild('final-photo', $r->mainPhoto->getPreviewUrl(441, null, Image::WIDTH));
                }
                if ($r->servings !== null) {
                    $recipe->addChild('yield', $r->servings);
                }
                if ($r->cooking_duration !== null) {
                    $recipe->addChild('duration', $r->cookingDurationString);
                }
            }

            $feed = $xml->asXML();
            Yii::app()->cache->set('recipesFeed', $feed, 0, new CExpressionDependency(date('Ymd')));
        }

        echo $feed;
    }
}
