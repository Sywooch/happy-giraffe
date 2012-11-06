<?php
class DecorController extends HController
{
    public function actionIndex($id = false)
    {
        $perPage = 29;
        $category = ($id) ? CookDecorationCategory::model()->findByPk($id) : null;
        $this->pageTitle = ($id) ? 'Оформление блюд: ' . $category->title : 'Оформление блюд';
        $dataProvider = CookDecoration::model()->indexDataProvider($id, $perPage);

        $this->render('index', compact('id', 'category', 'dataProvider'));
    }
}