<?php

class SpicesController extends HController
{
    public function actionIndex()
    {
        $this->pageTitle = 'Приправы и специи';
        $obj = CookSpices::model()->getSpicesByAlphabet();

        $this->render('index', compact('obj'));
    }

    public function actionCategory($id)
    {
        $model = CookSpicesCategories::model()->with('spices', 'photo')->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'Приправы и специи '.$model->title;

        $this->render('category', compact('model'));
    }

    public function actionView($id)
    {
        $model = CookSpices::model()->with('photo', 'categories', 'hints')->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'Приправы и специи '.$model->title;

        $this->render('view', compact('model'));
    }
}