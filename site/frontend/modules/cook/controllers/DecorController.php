<?php
class DecorController extends HController
{
    /**
     * @sitemap dataSource=sitemap
     */
    public function actionIndex($id = false)
    {
//        $model = new CookDecorationCategory;
//        var_dump(method_exists($model, 'getPhotoCollectionCount'));
//        die;


        $category = ($id) ? CookDecorationCategory::model()->findByPk($id) : null;
        $this->pageTitle = ($id) ? 'Оформление блюд: ' . $category->title : 'Оформление блюд';
        $dataProvider = CookDecoration::model()->indexDataProvider($id);

        if ($id !== false)
            $this->breadcrumbs = array(
                'Кулинария' => array('/cook/default/index'),
                'Украшения блюд' => array('/cook/decor/index'),
                $category->title,
            );
        else
            $this->breadcrumbs = array(
                'Кулинария' => array('/cook/default/index'),
                'Украшения блюд',
            );

        $this->render('index', compact('id', 'category', 'dataProvider'));
    }

    /**
     * Карта сайта
     * @return array
     */
    public function sitemap()
    {
        $models = Yii::app()->db->createCommand()
            ->select('photo_id')
            ->from('cook__decorations')
            ->queryAll();

        $data = array();
        foreach ($models as $model) {
            $data[] = array(
                'params' => array(
                    'id' => 'photo'.$model['photo_id'],
                ),
                'changefreq' => 'weekly'
            );
        }

        return $data;
    }
}