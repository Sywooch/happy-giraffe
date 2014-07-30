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
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
            $this->meta_title = 'Народные рецепты от болезни '.$disease->title;
        }

        $dp = RecipeBookRecipe::model()->getByDisease($this->disease_id);

        $this->render('index', compact('dp'));
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionView($id)
    {
        $data = RecipeBookRecipe::model()->with('disease', 'commentsCount', 'author', 'author.avatar', 'ingredients', 'ingredients.ingredient', 'ingredients.unit')->findByPk($id);
        if ($data === null)
            throw new CHttpException(404);

        $this->meta_title = $data->title;

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

    public function sitemapView()
    {
        $models = Yii::app()->db->createCommand()
            ->select('id, created, updated')
            ->from('recipe_book__recipes')
            ->queryAll();

        $data = array();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'id' => $model['id'],
                ),
                'changefreq' => 'daily',
                'lastmod' => ($model['updated'] === null) ? $model['created'] : $model['updated'],
            );
        }

        return $data;

    }
}