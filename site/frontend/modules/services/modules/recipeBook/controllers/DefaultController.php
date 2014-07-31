<?php

class DefaultController extends HController
{
    public $layout = '//layouts/lite/main';

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
}