<?php
class DecorController extends HController
{
    public function actionIndex($id = false)
    {
        $category = ($id) ? CookDecorationCategory::model()->findByPk($id) : null;
        $this->pageTitle = ($id) ? 'Оформление блюд: ' . $category->title : 'Оформление блюд';
        $dataProvider = CookDecoration::model()->indexDataProvider($id);

        $this->render('index', compact('id', 'category', 'dataProvider'));
    }
}