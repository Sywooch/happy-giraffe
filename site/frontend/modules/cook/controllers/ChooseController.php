<?php

class ChooseController extends HController
{
    public function actionIndex()
    {
        $this->pageTitle = 'Как выбрать продукты?';

        $this->render('index', array(
            'products' => CookChoose::model()->findAll(),
            'categories' => CookChooseCategory::model()->findAll()
        ));
    }

    public function actionCategory($id)
    {
        $model = CookChooseCategory::model()->with('photo', 'chooses')->findByAttributes(array('slug' => $id));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'Как выбрать  ' . $model->title_accusative;

        $this->render('category', compact('model'));
    }

    public function actionView($id)
    {
        $model = CookChoose::model()->with('photo', 'category')->findByAttributes(array('slug' => $id));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'Как выбрать ' . $model->title_accusative;

        $this->render('view', compact('model'));
    }
}