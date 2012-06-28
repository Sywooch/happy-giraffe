<?php
class DecorController extends HController
{
    public function actionIndex($id = false)
    {
        $category = ($id) ? CookDecorationCategory::model()->findByPk($id) : null;

        $this->pageTitle = ($id) ? 'Оформление блюд: ' . $category->title : 'Оформление блюд';

        $this->render('index', array(
            'id' => $id,
            'category' => $category,
            'dataProvider' => CookDecoration::model()->indexDataProvider($id, 9)
        ));
    }
}