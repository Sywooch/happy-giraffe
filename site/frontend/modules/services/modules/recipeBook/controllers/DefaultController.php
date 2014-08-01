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
            return array(
                array(
                    'COutputCache',
                    'duration' => 300,
                    'varyByParam' => array_keys($_GET),
                    'varyByExpression' => 'Yii::app()->vm->getVersion()',
                ),
            );

        }

        return parent::filters();
    }

    public function actionIndex($slug = null)
    {
        $diseaseId = null;
        $categoryId = null;
        if ($slug !== null) {
            $disease = RecipeBookDisease::model()->findByAttributes(array('slug' => $slug));
            if ($disease !== null) {
                $diseaseId = $disease->id;
            } else {
                $category = RecipeBookDiseaseCategory::model()->findByAttributes(array('slug' => $slug));
                if ($category === null) {
                    throw new CHttpException(404);
                }
                $categoryId = $category->id;
            }

            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
            $this->meta_title = 'Народные рецепты от болезни ' . $disease->title;
        }

        $dp = RecipeBookRecipe::getDp($diseaseId, $categoryId);
        $categories = RecipeBookDiseaseCategory::model()->alphabetical()->findAll();

        $this->render('index', compact('categories', 'dp', 'slug', 'diseaseId'));
    }

    public function actionView($id)
    {
        $recipe = RecipeBookRecipe::model()->single()->findByPk($id);
        if ($recipe === null) {
            throw new CHttpException(404);
        }

        $this->meta_title = $recipe->title;

        $this->render('view', compact('recipe'));
    }
}