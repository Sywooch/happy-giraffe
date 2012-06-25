<?php

class SpicesController extends HController
{
    public function actionIndex()
    {
        $this->pageTitle = 'Приправы и специи';
        $obj = CookSpice::model()->getSpicesByAlphabet();

        $this->render('index', compact('obj'));
    }

    public function actionCategory($id)
    {
        $model = CookSpiceCategory::model()->with('spices', 'photo')->findByAttributes(array('slug'=>$id));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'Приправы и специи '.$model->title;

        $this->render('category', compact('model'));
    }

    public function actionView($id)
    {
        $model = CookSpice::model()->with('photo', 'categories', 'hints')->findByAttributes(array('slug'=>$id));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'Приправы и специи '.$model->title;
        $recipes = CookRecipe::model()->findByIngredient($model->ingredient_id, 3);
        /*print_r($recipes);
        exit();*/

        $this->render('view', compact('model', 'recipes'));
    }
}