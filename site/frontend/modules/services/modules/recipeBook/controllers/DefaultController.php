<?php

class DefaultController extends HController
{
    public $layout = 'rec-layout';
    public $index = false;

    public function filters()
    {
        return array(
            'ajaxOnly + diseases, getAlphabetList, getCategoryList, vote',
        );
    }

    public function actionIndex()
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
    }
}