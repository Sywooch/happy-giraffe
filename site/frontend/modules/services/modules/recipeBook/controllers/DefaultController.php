<?php

class DefaultController extends HController
{
    public $layout = '//layouts/lite/main';

    protected function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $cs = Yii::app()->clientScript;
            $cs->registerPackage('lite_recipes');
            $cs->useAMD = true;
            return true;
        }
    }

    public function filters()
    {
        if (Yii::app()->user->isGuest) {
//            return array(
//                array(
//                    'COutputCache',
//                    'duration' => 300,
//                    'varyByParam' => array_keys($_GET),
//                    'varyByExpression' => 'Yii::app()->vm->getVersion()',
//                ),
//            );

        }

        return parent::filters();
    }

    public function actionIndex()
    {
        $dp = RecipeBookRecipe::getDp(null, null);
        $categories = RecipeBookDiseaseCategory::model()->alphabetical()->findAll();

        $links = array();
        foreach ($categories as $c) {
            $links[$c->title] = $c->getUrl();
        }

        $this->breadcrumbs = array(
            'Народные рецепты',
        );
        $this->render('index', compact('links', 'dp'));
    }

    public function actionDisease($slug)
    {
        $disease = RecipeBookDisease::model()->findByAttributes(array('slug' => $slug));
        if ($disease === null) {
            throw new CHttpException(404);
        }
        $dp = RecipeBookRecipe::getDp($disease->id, null);

        $links = array();

        $this->meta_title = 'Народные рецепты от болезни ' . $disease->title;
        $this->breadcrumbs = array(
            'Народные рецепты' => array('/services/recipeBook/default/index'),
            $disease->title,
        );
        $this->render('index', compact('links', 'dp'));
    }

    public function actionCategory($slug)
    {
        $category = RecipeBookDiseaseCategory::model()->with('diseases')->findByAttributes(array('slug' => $slug));
        if ($category === null) {
            throw new CHttpException(404);
        }
        $dp = RecipeBookRecipe::getDp(null, $category->id);

        $links = array();
        foreach ($category->diseases as $d) {
            $links[$d->title] = $d->getUrl();
        }

        $this->breadcrumbs = array(
            'Народные рецепты',
        );
        $this->render('index', compact('links', 'dp'));
    }

    public function actionView($id)
    {
        $recipe = RecipeBookRecipe::model()->single()->findByPk($id);
        if ($recipe === null) {
            throw new CHttpException(404);
        }

        $this->meta_title = $recipe->title;

        $this->breadcrumbs = array(
            'Народные рецепты' => array('/services/recipeBook/default/index'),
            $recipe->disease->title => $recipe->disease->getUrl(),
            $recipe->title,
        );
        $this->render('view', compact('recipe'));
    }
}