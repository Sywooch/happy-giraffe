<?php

class DefaultController extends HController
{
    public $layout = 'rec-layout';
    public $index = false;
    public $nav;
    public $disease_id = null;

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
                'actions' => array('form'),
                'users' => array('?'),
            ),
        );
    }

    public function init()
    {
        $this->nav = RecipeBookDiseaseCategory::model()->findAll(array(
            'with' => array(
                'diseases' => array(
                    'index' => 'id',
                    'with' => array(
                        'recipesCount',
                    ),
                ),
            ),
        ));

        parent::init();
    }

    public function actionIndex($slug = null)
    {
        if ($slug !== null) {
            $disease = RecipeBookDisease::model()->findByAttributes(array('slug' => $slug));
            if ($disease === null)
                throw new CHttpException(404);
            $this->disease_id = $disease->id;
        }

        $dp = RecipeBookRecipe::model()->getByDisease($this->disease_id);

        $this->render('index', compact('dp'));
    }

    public function actionView($id)
    {
        $data = RecipeBookRecipe::model()->with('disease', 'commentsCount', 'author', 'author.avatar', 'ingredients', 'ingredients.ingredient', 'ingredients.unit')->findByPk($id);
        if ($data === null)
            throw new CHttpException(404);

        $this->disease_id = $data->disease_id;

        $this->render('view', compact('data'));
    }

    public function actionForm($id = null)
    {
        if ($id === null) {
            $recipe = new RecipeBookRecipe;
            $ingredients = array();
        } else {
            $recipe = RecipeBookRecipe::model()->with('disease', 'disease.category', 'disease.category.diseases')->findByPk($id);
            $ingredients = $recipe->ingredients;
        }

        if (isset($_POST['RecipeBookRecipe'])) {
            $ingredients = array();
            $recipe->attributes = $_POST['RecipeBookRecipe'];
            if ($recipe->isNewRecord)
                $recipe->author_id = Yii::app()->user->id;
            foreach ($_POST['RecipeBookRecipeIngredient'] as $i) {
                if (! empty($i['ingredient_id']) || ! empty($i['value']) || $i['unit_id'] != RecipeBookRecipeIngredient::EMPTY_INGREDIENT_UNIT) {
                    $ingredient = new RecipeBookRecipeIngredient;
                    $ingredient->attributes = $i;
                    $ingredient->setValue();
                    $ingredient->recipe_id = $recipe->id;
                    $ingredients[] = $ingredient;
                }
            }
            $recipe->ingredients = $ingredients;
            if ($recipe->withRelated->save(true, array('ingredients'))) {
                $this->redirect($recipe->url);
            }
        }

        if (empty($ingredients))
            $ingredients = RecipeBookRecipeIngredient::model()->getEmptyModel(3);

        $diseaseCategories = RecipeBookDiseaseCategory::model()->findAll();
        $units = RecipeBookUnit::model()->findAll();
        $this->layout = '//layouts/main';
        $this->render('form', compact('recipe', 'ingredients', 'diseaseCategories', 'units'));
    }

    public function actionDiseases($category_id)
    {
        $htmlOptions = array(
            'prompt' => 'не выбрана',
        );

        $diseases = RecipeBookDisease::model()->findAllByAttributes(array('category_id' => $category_id));
        echo CHtml::listOptions('', CHtml::listData($diseases, 'id', 'title'), $htmlOptions);
    }

    public function actionAc($term)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'id, title';
        $criteria->limit = 10;
        $criteria->compare('title', $term . '%', true, 'AND', false);

        $ingredients = RecipeBookIngredient::model()->findAll($criteria);
        $_ingredients = array();
        foreach ($ingredients as $i) {
            $_ingredients[] = array(
                'label' => $i->title,
                'id' => $i->id,
            );
        }
        echo CJSON::encode($_ingredients);
    }

    /*public function actionIndex()
    {
        $this->pageTitle = 'Книга народных рецептов от детских болезней';
        $this->index = true;
        $diseases = RecipeBookDisease::model()->with(array(
            'category' => array(
                'select' => array('title')
            )
        ))->findAll(array(
                'order' => 't.title',
                'select' => array('id', 'title', 'slug', 'category_id'))
        );
        $alphabetList = RecipeBookDisease::GetDiseaseAlphabetList($diseases);
        $categoryList = RecipeBookDisease::GetDiseaseCategoryList($diseases);

        $this->render('index', array(
            'alphabetList' => $alphabetList,
            'categoryList' => $categoryList
        ));
    }

    public function actionEdit($id = null)
    {
        if (Yii::app()->user->isGuest)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if ($id === null) {
            $model = new RecipeBookRecipe;
        }
        else
        {
            $model = RecipeBookRecipe::model()->with(array('disease.category.diseases', 'purposes', 'ingredients'))->findByPk($id);
            if ($model === null) {
                throw new CHttpException(404, 'Такой записи не существует.');
            }
        }

        $ingredients = array();
        if (isset($_POST['RecipeBookRecipe'], $_POST['RecipeBookIngredient'])) {
            $model->attributes = $_POST['RecipeBookRecipe'];
            $model->author_id = Yii::app()->user->id;
            $model->purposes = $model->purposeIds;
            $valid = $model->validate();

            foreach ($_POST['RecipeBookIngredient'] as $i)
            {
                $ingredient = new RecipeBookIngredient;
                $ingredient->attributes = $i;
                $valid = $ingredient->validate() && $valid;
                $ingredients[] = $ingredient;
            }

            if ($valid) {
                $isNewRecord = $model->isNewRecord;
                $model->save(false);
                if (!$isNewRecord) {
                    RecipeBookIngredient::model()->deleteAllByAttributes(array('recipe_id' => $model->id));
                }
                foreach ($ingredients as $ingredient)
                {
                    $ingredient->recipe_id = $model->id;
                    $ingredient->save(false);
                }
                if (!$isNewRecord) {
                    $model->refresh();
                }

                $this->redirect($this->createUrl('/recipeBook/default/view', array('id' => $model->id)));
            }
        }

        $this->render('edit', array(
            'model' => $model,
            'ingredients' => $ingredients,
        ));
    }

    public function actionList()
    {
        $recipies = RecipeBookRecipe::model()->findAll();
        $this->render('list', array(
            'recipies' => $recipies,
        ));
    }

    public function actionDiseases()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new RecipeBookRecipe;
            $category_id = $_POST['disease_category'];

            $diseases = RecipeBookDisease::model()->findAllByAttributes(array('category_id' => $category_id));
            echo CHtml::listOptions('', array(''=>'Выберите болезнь')+CHtml::listData($diseases, 'id', 'title'), $null);
        }
    }

    public function actionGetAlphabetList()
    {
        $diseases = RecipeBookDisease::model()->findAll(array('order' => 'title', 'select' => array('id', 'title', 'slug')));
        $alphabetList = RecipeBookDisease::GetDiseaseAlphabetList($diseases);

        $this->renderPartial('alphabet_list', array(
            'alphabetList' => $alphabetList,
        ));
    }

    public function actionGetCategoryList()
    {
        $diseases = RecipeBookDisease::model()->with(array(
            'category' => array(
                'select' => array('title')
            )
        ))->findAll(
            array(
                'order' => 't.title',
                'select' => array('id', 'title', 'slug', 'category_id')
            )
        );
        $categoryList = RecipeBookDisease::GetDiseaseCategoryList($diseases);

        $this->renderPartial('category_list', array(
            'categoryList' => $categoryList
        ));
    }

    public function actionDisease($url)
    {
        $model = RecipeBookDisease::model()->with(array(
            'category' => array(
                'select' => array('title')
            )
        ))->find(array(
            'select' => array('id', 'title', 'category_id'),
            'condition' => 't.slug = :slug',
            'params' => array(':slug' => $url)
        ));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $cat_diseases = RecipeBookDisease::model()->findAll(array(
            'order' => 'title',
            'select' => array('id', 'title', 'slug'),
            'condition' => 'category_id=' . $model->category_id
        ));

        $criteria = new CDbCriteria;
        $criteria->compare('disease_id', $model->id);
        $criteria->with = array('author'=>array('select'=>array('id','last_name','gender','avatar_id')));
        $count = RecipeBookRecipe::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $recipes = RecipeBookRecipe::model()->with(array(
            'ingredients',
            'commentsCount'
        ))->findAll($criteria);

        $this->render('disease', array(
            'model' => $model,
            'cat_diseases' => $cat_diseases,
            'recipes' => $recipes,
            'pages' => $pages,
        ));
    }

    public function actionView($id)
    {
        $model = RecipeBookRecipe::model()->with(array(
            'disease' => array(
                'select' => array('category_id', 'id', 'title', 'slug')
            ),
            'disease.category' => array(
                'select' => array('title')
            ),
            'ingredients',
            'commentsCount',
            'author'=>array('select'=>array('id','first_name','last_name','gender','avatar_id'))
        ))->findByPk($id);

        if (!isset($model))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $model->views_amount++;
        $model->update(array('views_amount'));

        $cat_diseases = RecipeBookDisease::model()->findAll(array(
            'order' => 't.title',
            'select' => array('id', 'title', 'slug'),
            'condition' => 'category_id=' . $model->disease->category_id
        ));

        $more_recipes = RecipeBookRecipe::model()->findAll(array(
            'order' => new CDbExpression('RAND()'),
            'limit' => 3,
            'select' => array('id', 'title'),
            'condition' => 'disease_id=' . $model->disease_id . ' AND id != ' . $id,
            'with'=>'ingredients'
        ));

        if ($model->author_id == Yii::app()->user->id) {
            UserNotification::model()->deleteByEntity(UserNotification::NEW_COMMENT, $model);
            UserNotification::model()->deleteByEntity(UserNotification::NEW_REPLY, $model);
        }

        $this->render('view', array(
            'model' => $model,
            'active_disease' => $model->disease,
            'cat_diseases' => $cat_diseases,
            'more_recipes' => $more_recipes
        ));
    }

    public function actionVote()
    {
        if (Yii::app()->request->isAjaxRequest && !Yii::app()->user->isGuest) {
            $model_id = $_POST['id'];
            $vote = $_POST['vote'];
            $model = RecipeBookRecipe::model()->findByPk($model_id);
            if ($model) {
                $model->vote(Yii::app()->user->id, $vote);
                $model->refresh();

                $response = array(
                    'success' => true,
                    'votes_pro' => $model->votes_pro,
                    'votes_con' => $model->votes_con,
                    'pro_percent' => $model->getPercent(1),
                    'con_percent' => $model->getPercent(0),
                    'total' => $model->votes_pro - $model->votes_con,
                );
            }
            else
            {
                $response = array(
                    'success' => false,
                );
            }

            echo CJSON::encode($response);
        }
    }*/
}