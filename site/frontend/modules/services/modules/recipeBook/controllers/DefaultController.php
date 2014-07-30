<?php

class DefaultController extends HController
{
    public $layout = '//layouts/lite/main';

    public function actionIndex($slug = null)
    {
        $diseaseId = null;
        if ($slug !== null) {
            $disease = RecipeBookDisease::model()->findByAttributes(array('slug' => $slug));
            if ($disease === null) {
                throw new CHttpException(404);
            }
            $diseaseId = $disease->id;
        }

        $dp = RecipeBookRecipe::getDp($diseaseId);
        $categories = RecipeBookDiseaseCategory::model()->alphabetical()->findAll();

        $this->render('index', compact('categories', 'dp'));
    }
}