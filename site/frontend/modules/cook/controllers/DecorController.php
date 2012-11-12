<?php
class DecorController extends HController
{
    public function actionIndex($id = false)
    {
//        $model = new CookDecorationCategory;
//        var_dump(method_exists($model, 'getPhotoCollectionCount'));
//        die;


        $category = ($id) ? CookDecorationCategory::model()->findByPk($id) : null;
        $this->pageTitle = ($id) ? 'Оформление блюд: ' . $category->title : 'Оформление блюд';
        $dataProvider = CookDecoration::model()->indexDataProvider($id);

        $this->breadcrumbs = array(
            'Кулинария' => array('/cook/default/index'),
            'Украшения блюд' => array('/cook/decor/index'),
        );

        if ($id !== false)
            $this->breadcrumbs[$category->title] = $category->url;

        $this->render('index', compact('id', 'category', 'dataProvider'));
    }
}