<?php

class SpicesController extends HController
{
    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Приправы и специи';
        $obj = CookSpice::model()->getSpicesByAlphabet();

        $this->render('index', compact('obj'));
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionView($id)
    {
        $model = CookSpiceCategory::model()->with('spices', 'photo')->findByAttributes(array('slug' => $id));
        if ($model === null) {

            $model = CookSpice::model()->with('photo', 'categories', 'hints')->findByAttributes(array('slug' => $id));
            if ($model === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $this->pageTitle = 'Приправы и специи ' . $model->title;
            $recipes = CookRecipe::model()->findByIngredient($model->ingredient_id, 3);

            $this->render('view', compact('model', 'recipes'));
        } else {
            $this->pageTitle = 'Приправы и специи ' . $model->title;

            $this->render('category', compact('model'));
        }
    }

    public function sitemapView()
    {
        $sql = 'SELECT slug FROM cook__spices UNION SELECT slug FROM cook__spices__categories';
        $command = Yii::app()->db->createCommand($sql);
        $models = $command->queryAll();

        $data = array();
        foreach ($models as $model) {
            $data[] = array(
                'params' => array(
                    'id' => $model['slug'],
                ),
            );
        }

        return $data;
    }
}