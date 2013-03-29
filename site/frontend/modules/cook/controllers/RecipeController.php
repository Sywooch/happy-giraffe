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
            array(
                'CHttpCacheFilter + view',
                'lastModified' => $this->lastModified(),
            ),
            //'ajaxOnly + ac, searchByIngredientsResult, advancedSearchResult, autoSelect'
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

        if ($this->section == 1) {
            $service = Service::model()->findByPk(11);
            $service->userUsedService();
        }

        return parent::beforeAction($action);
    }

    public function actionIndex($type = 0, $section = null)
    {
        $this->pageTitle = 'Кулинарные рецепты от Веселого Жирафа';
        if (!empty($type))
            $this->pageTitle = CActiveRecord::model($this->modelName)->types[$type] . ' - ' . $this->pageTitle;

        $this->layout = '//layouts/recipe';
        $this->currentType = $type;

        $dp = CActiveRecord::model($this->modelName)->getByType($type);
        $this->counts = CActiveRecord::model($this->modelName)->counts;
        $dp->totalItemCount = $this->counts[$type];

        if (empty($type))
            $this->breadcrumbs = array(
                'Кулинария' => array('/cook'),
                $this->section == 0 ? 'Кулинарные рецепты' : 'Рецепты для мультиварок',
            );
        else
            $this->breadcrumbs = array(
                'Кулинария' => array('/cook'),
                ($this->section == 0 ? 'Кулинарные рецепты' : 'Рецепты для мультиварок') => array('/cook/recipe/index', 'section' => $this->section),
                CookRecipe::model()->types[$type],
            );

        $this->render('index', compact('dp', 'type'));
    }

    /**
     * @sitemap dataSource=sitemapTag
     */
    public function actionTag($tag = null, $type = 0)
    {
        if (empty($tag)) {
            if (Yii::app()->user->checkAccess('recipe_tags'))
                $this->render('tag_list');
            else
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
            Yii::app()->end();
        }

        $model = $this->loadTag($tag);
        if (CookRecipeTag::TAG_VALENTINE == $model->id && strpos(Yii::app()->request->requestUri, 'valentinesDay') === false) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $model->url);
            Yii::app()->end();
        }

        $this->pageTitle = $model->title . ' - Кулинарные рецепты от Веселого Жирафа';
        $this->layout = '//layouts/recipe';
        $this->currentType = $type;

        if (CookRecipeTag::TAG_VALENTINE == $model->id)
            $this->body_class .= ' body__valentine';

        $dp = CActiveRecord::model($this->modelName)->getByTag($tag, $type);
        $this->counts = CActiveRecord::model($this->modelName)->getCountsByTag($tag);
        $dp->totalItemCount = $this->counts[$type];

        if (empty($type))
            $this->breadcrumbs = array(
                'Кулинария' => array('/cook'),
                'Кулинарные рецепты' => array('/cook/recipe'),
                strip_tags($model->title)
            );
        else
            $this->breadcrumbs = array(
                'Кулинария' => array('/cook'),
                'Кулинарные рецепты' => array('/cook/recipe'),
                strip_tags($model->title) => $this->createUrl('/cook/recipe/tag', array('tag' => $tag)),
                CookRecipe::model()->types[$type],
            );

        $this->render('tag', compact('dp', 'model'));
    }

    public function actionCookBook($type = 0)
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect('/cook/recipe/');
            Yii::app()->end();
        }

        $this->pageTitle = 'Моя кулинарная книга';
        $this->layout = '//layouts/recipe';
        $this->currentType = $type;

        $dp = CActiveRecord::model($this->modelName)->getByCookBook($type);
        $this->counts = CActiveRecord::model($this->modelName)->getCountsByCookBook($type);
        $dp->totalItemCount = $this->counts[$type];

        if (empty($type))
            $this->breadcrumbs = array(
                'Кулинария' => array('/cook'),
                ($this->section == 0 ? 'Кулинарные рецепты' : 'Рецепты для мультиварок') => array('/cook/recipe/index', 'section' => $this->section),
                'Моя кулинарная книга'
            );
        else
            $this->breadcrumbs = array(
                'Кулинария' => array('/cook'),
                ($this->section == 0 ? 'Кулинарные рецепты' : 'Рецепты для мультиварок') => array('/cook/recipe/index', 'section' => $this->section),
                'Моя кулинарная книга' => array('/cook/recipe/cookBook', 'section' => $this->section),
                CookRecipe::model()->types[$type],
            );


        $this->render('cookbook', compact('dp'));
    }

    public function actionForm($id = null)
    {
        $this->pageTitle = 'Добавить рецепт';

        if ($id === null) {
            $recipe = new $this->modelName;
            $ingredients = array();
        } else {
            $recipe = CActiveRecord::model($this->modelName)->active()->with(array(
                'photo',
                'cuisine',
                'ingredients' => array(
                    'order' => 'ingredients.id',
                    'with' => array(
                        'ingredient' => array(
                            'with' => 'availableUnits',
                        ),
                        'unit',
                    )
                ),
            ))->findByPk($id);
            if ($recipe === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $ingredients = $recipe->ingredients;
        }

        if (isset($_POST[$this->modelName])) {
            $recipe->attributes = $_POST[$this->modelName];
            if ($recipe->isNewRecord)
                $recipe->author_id = Yii::app()->user->id;

            $ingredients = array();
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

            if ($recipe->withRelated->validate(array('ingredients'))) {
                CookRecipeIngredient::model()->deleteAll('recipe_id = :recipe_id', array(':recipe_id' => $recipe->id));
                $recipe->withRelated->save(false, array('ingredients'));
                $this->redirect(array('/cook/recipe/view', 'id' => $recipe->id, 'section' => $this->section));
            }
        }

        if (empty($ingredients))
            $ingredients = CookRecipeIngredient::model()->getEmptyModel(3);

        $cuisines = CookCuisine::model()->findAll();
        $units = CookUnit::model()->findAll();

        $actionLabel = $recipe->isNewRecord ? 'Добавить' : 'Редактировать';
        $sectionLabel = $this->section == 0 ? 'рецепт' : 'рецепт для мультиварки';
        $this->breadcrumbs = array(
            'Кулинария' => array('/cook'),
            $actionLabel . ' ' . $sectionLabel,
        );

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
     * @sitemap dataSource=sitemapView
     */
    public function actionView($id, $section, $lastPage = null, $ajax = null)
    {
        $recipe = CActiveRecord::model($this->modelName)->active()->with(array(
            'photo',
            'attachPhotos',
            'cuisine',
            'ingredients' => array(
                'order' => 'ingredients.id',
                'with' => array(
                    'ingredient',
                    'unit',
                )
            ),
            'author',
            'commentsCount'
        ))->findByPk($id);
        if ($recipe === null)
            throw new CHttpException(404, 'Такого рецепта не существует');

        $this->counts = CActiveRecord::model($this->modelName)->counts;
        $this->currentType = $recipe->type;
        $this->layout = '//layouts/recipe';
        $this->pageTitle = $recipe->title . ' - Кулинарные рецепты от Веселого Жирафа';

        if (!Yii::app()->user->isGuest)
            UserNotification::model()->deleteByEntity($recipe, Yii::app()->user->id);

        $this->breadcrumbs = array(
            'Кулинария' => array('/cook'),
            ($this->section == 0 ? 'Кулинарные рецепты' : 'Рецепты для мультиварок') => array('/cook/recipe/index', 'section' => $this->section),
            $recipe->typeString => array('/cook/recipe/index', 'type' => $recipe->type, 'section' => $this->section),
            $recipe->title,
        );
        $this->registerCounter();

        $this->render('view', compact('recipe'));
    }

    public function actionSearch($type = null, $text = false)
    {
        $this->layout = '//layouts/recipe';
        $this->pageTitle = 'Поиск рецептов';
        $this->currentType = $type;
        $text = urldecode($text);

        $this->breadcrumbs = array(
            'Кулинария' => array('/cook'),
            ($this->section == 0 ? 'Кулинарные рецепты' : 'Рецепты для мультиварок') => array('/cook/recipe/index', 'section' => $this->section),
            'Поиск',
        );

        list($dataProvider, $this->counts) = CookRecipe::model()->searchByName($text, $type);
        $this->render('search', compact('dataProvider', 'text', 'type'));
    }

    public function actionSearchByIngredients()
    {
        $this->pageTitle = 'Поиск рецептов по ингредиентам';

        $this->breadcrumbs = array(
            'Кулинария' => array('/cook'),
            ($this->section == 0 ? 'Кулинарные рецепты' : 'Рецепты для мультиварок') => array('/cook/recipe/index', 'section' => $this->section),
            'Поиск по ингредиентам'
        );

        $this->render('searchByIngredients');
    }

    public function actionSearchByIngredientsResult()
    {
        $ingredients = Yii::app()->request->getQuery('ingredients', array());
        $type = Yii::app()->request->getQuery('type', null);
        $ingredients = array_filter($ingredients);
        $recipes = CActiveRecord::model($this->modelName)->findByIngredients($ingredients, $type);
        $this->renderPartial('searchByIngredientsResult', compact('recipes', 'type'), false, true);
    }

    public function actionAdvancedSearch()
    {
        $this->pageTitle = 'Расширенный поиск рецептов';
        $cuisines = CookCuisine::model()->findAll();

        $this->breadcrumbs = array(
            'Кулинария' => array('/cook'),
            ($this->section == 0 ? 'Кулинарные рецепты' : 'Рецепты для мультиварок') => array('/cook/recipe/index', 'section' => $this->section),
            'Расширенный поиск'
        );

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
        $this->renderPartial('advancedSearchResult', compact('recipes'), false, true);
    }

    public function actionAc($term)
    {
        $ingredients = CookIngredient::model()->autoComplete($term, 100, false, true);
        echo CJSON::encode($ingredients);
    }

    public function actionAutoSelect($term)
    {
        $ing = CookIngredient::model()->with('unit')->findOneByName($term);
        if ($ing !== null) {
            $response = array(
                'success' => true,
                'i' => array(
                    'value' => $ing->title,
                    'label' => $ing->title,
                    'id' => $ing->id,
                    'unit_id' => $ing->unit_id,
                    'density' => $ing->density,
                    'unit' => $ing->unit->title
                ),
            );
        } else {
            $response = array(
                'success' => false,
            );
        }

        echo CJSON::encode($response);
    }

    public function sitemapView()
    {
        $models = Yii::app()->db->createCommand()
            ->select('id, section, created, updated')
            ->from('cook__recipes')
            ->queryAll();

        $data = array();
        foreach ($models as $model) {
            $t = date("Y-m-d H:i:s", $this->getRecipeLastUpdatedTime($model['id']));
            $data[] = array(
                'params' => array(
                    'id' => $model['id'],
                    'section' => $model['section'],
                ),
                'changefreq' => 'daily',
                'lastmod' => $t,
            );
        }

        return $data;
    }

    public function sitemapTag()
    {
        $models = Yii::app()->db->createCommand()
            ->select('id')
            ->from(CookRecipeTag::model()->tableName())
            ->queryAll();

        $data = array();
        foreach ($models as $model) {
            $data[] = array(
                'params' => array(
                    'tag' => $model['id'],
                ),
                'changefreq' => 'daily',
            );
        }

        return $data;
    }

    public function actionFeed()
    {
        header("Content-type: text/xml; charset=utf-8");
        $feed = Yii::app()->cache->get('recipesFeed');
        if ($feed === false) {
            $recipes = CookRecipe::model()->with('cuisine', 'author', 'ingredients', 'ingredients.ingredient', 'ingredients.unit')->findAll(array(
                'order' => 'created DESC',
                'condition' => 't.id != 16589',
                'limit' => 3000,
            ));

            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><entities/>');

            foreach ($recipes as $r) {
                if (empty($r->ingredients))
                    continue;

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

    public function actionAddTag()
    {
        if (!Yii::app()->user->checkAccess('recipe_tags'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $recipe_id = Yii::app()->request->getPost('recipe_id');
        $tag_id = Yii::app()->request->getPost('tag_id');

        UserAttributes::set(Yii::app()->user->id, 'last_recipe_tag_id', $tag_id);

        $result = Yii::app()->db->createCommand()
            ->insert('cook__recipe_recipes_tags',
            array('recipe_id' => $recipe_id, 'tag_id' => $tag_id));

        echo CJSON::encode(array('status' => $result));
    }

    public function actionRemoveTag()
    {
        if (!Yii::app()->user->checkAccess('recipe_tags'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $recipe_id = Yii::app()->request->getPost('recipe_id');
        $tag_id = Yii::app()->request->getPost('tag_id');

        $result = Yii::app()->db->createCommand()
            ->delete('cook__recipe_recipes_tags', 'recipe_id = :recipe_id AND tag_id=:tag_id',
            array(':recipe_id' => $recipe_id, ':tag_id' => $tag_id));

        echo CJSON::encode(array('status' => $result));
    }

    public function actionBook()
    {
        $recipe = $this->loadModel(Yii::app()->request->getPost('recipe_id'));

        if (Yii::app()->user->isGuest) {
            Yii::app()->user->setState('recipe_id', $recipe->id);
            Yii::app()->user->setState('redirectUrl', '/cook/recipe/cookBook/');
            echo CJSON::encode(array('status' => false));
        } else {
            $result = $recipe->book();
            $count = CookRecipe::userBookCount();
            $count = $count . ' ' . HDate::GenerateNoun(array('рецепт', 'рецепта', 'рецептов'), $count);

            echo CJSON::encode(array('status' => true, 'result' => $result, 'count' => $count));
        }
    }

    public function getTypeUrl($id)
    {
        if (empty($id))
            $params = array();
        else
            $params = array('type' => $id);

        if ($this->action->id == 'search') {
            $params['text'] = $_GET['text'];
            return $this->createUrl('/cook/recipe/search', $params);
        } elseif ($this->action->id == 'tag') {
            $params['tag'] = $_GET['tag'];
            return $this->createUrl('/cook/recipe/tag', $params);
        } elseif ($this->action->id == 'cookBook') {
            return $this->createUrl('/cook/recipe/cookBook', $params);
        } else {
            $params['section'] = $this->section;
            return $this->createUrl('/cook/recipe/index', $params);
        }
    }

    protected function lastModified()
    {
        if (!Yii::app()->user->isGuest)
            return null;

        $recipe_id = Yii::app()->request->getQuery('id');
        return date("Y-m-d H:i:s", $this->getRecipeLastUpdatedTime($recipe_id));
    }

    public function getRecipeLastUpdatedTime($id)
    {
        $sql = "SELECT
                    GREATEST(
                        COALESCE(MAX(c.created), '0000-00-00 00:00:00'),
                        COALESCE(MAX(c.updated), '0000-00-00 00:00:00'),
                        COALESCE(MAX(cm.created), '0000-00-00 00:00:00'),
                        COALESCE(MAX(cm.updated), '0000-00-00 00:00:00')
                    )
                FROM cook__recipes c
                LEFT OUTER JOIN comments cm
                ON cm.entity = 'CookRecipe' AND cm.entity_id = :recipe_id";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $t1 = strtotime($command->queryScalar());

        //проверяем блок внутренней перелинковки
        $url = 'http://www.happy-giraffe.ru' . Yii::app()->request->getRequestUri();
        $t2 = InnerLinksBlock::model()->getUpTime($url);

        if (empty($t2))
            return $t1;

        return max($t1, $t2);
    }

    /**
     * @param int $id model id
     * @return CookRecipe
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = CookRecipe::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    /**
     * @param int $id model id
     * @return CookRecipeTag
     * @throws CHttpException
     */
    public function loadTag($id)
    {
        $model = CookRecipeTag::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
