<?php

class ChooseController extends HController
{
    public function actionIndex()
    {
        $this->pageTitle = 'Как выбрать продукты?';

        $this->render('index', array(
            'categories' => CookChooseCategory::model()->with('chooses')->findAll()
        ));
    }

    public function actionView($id)
    {
        $model = CookChooseCategory::model()->with('photo', 'chooses')->findByAttributes(array('slug' => $id));
        if ($model === null) {
            $model = CookChoose::model()->with('photo', 'category')->findByAttributes(array('slug' => $id));
            if ($model === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $this->pageTitle = 'Как выбрать ' . $model->title_accusative;
            $this->render('view', compact('model'));
        } else {

            $this->pageTitle = 'Как выбрать  ' . $model->title_accusative;
            $this->render('category', compact('model'));
        }
    }
}