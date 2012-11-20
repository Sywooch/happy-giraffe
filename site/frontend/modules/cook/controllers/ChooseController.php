<?php

class ChooseController extends HController
{
    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Как выбрать продукты?';

        $this->breadcrumbs = array(
            'Кулинария' => array('/cook/default/index'),
            'Как выбрать продукты?',
        );

        $this->render('index', array(
            'categories' => CookChooseCategory::model()->with('chooses')->findAll()
        ));
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionView($id)
    {
        $model = CookChooseCategory::model()->with('photo', 'chooses')->findByAttributes(array('slug' => $id));
        if ($model === null) {
            $model = CookChoose::model()->with('photo', 'category')->findByAttributes(array('slug' => $id));
            if ($model === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $this->pageTitle = 'Как выбрать ' . $model->title_accusative;

            $this->breadcrumbs = array(
                'Кулинария' => array('/cook/default/index'),
                'Как выбрать продукты?' => array('/cook/choose/index'),
                $model->category->title => $model->category->url,
                $model->title,
            );

            $this->render('view', compact('model'));
        } else {
            $this->pageTitle = 'Как выбрать  ' . $model->title_accusative;

            $this->breadcrumbs = array(
                'Кулинария' => array('/cook/default/index'),
                'Как выбрать продукты?' => array('/cook/choose/index'),
                $model->title,
            );

            $this->render('category', compact('model'));
        }
    }

    public function sitemapView()
    {
        $sql = 'SELECT slug FROM cook__choose UNION SELECT slug FROM cook__choose__categories';
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