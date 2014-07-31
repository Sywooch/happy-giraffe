<?php

class DefaultController extends HController
{
    public $layout = '//layouts/lite/main';

//    public function filters()
//    {
//        if (Yii::app()->user->isGuest) {
//            return array(
//                array(
//                    'COutputCache',
//                    'duration' => 300,
//                    'varyByParam' => array_keys($_GET),
//                    //'varyByExpression' => 'Yii::app()->vm->getVersion()',
//                ),
//            );
//
//        }
//
//        return parent::filters();
//    }

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

        }

        $dp = RecipeBookRecipe::getDp($diseaseId, $categoryId);
        $categories = RecipeBookDiseaseCategory::model()->alphabetical()->findAll();

        $this->render('index', compact('categories', 'dp', 'slug', 'diseaseId'));
    }

    public function actionView($id)
    {
        $recipe = RecipeBookRecipe::model()->findByPk($id);
        if ($recipe === null) {
            throw new CHttpException(404);
        }

        $this->render('view', compact('recipe'));
    }
}