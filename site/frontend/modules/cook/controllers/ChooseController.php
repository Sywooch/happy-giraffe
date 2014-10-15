<?php

class ChooseController extends LiteController
{

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->render('index', array(
            'categories' => CookChooseCategory::model()->cache(3600)->with('chooses')->findAll()
        ));
    }

    public function beforeAction($action)
    {
        $package = Yii::app()->user->isGuest ? 'lite_cook_choose' : 'lite_cook_choose_user';
        Yii::app()->clientScript->registerPackage($package);
        Yii::app()->clientScript->useAMD = true;
        return parent::beforeAction($action);
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionView($id)
    {
        $model = CookChoose::model()->with('photo', 'category')->findByAttributes(array('slug' => $id));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->render('view', compact('model'));
    }

    public function sitemapView()
    {
        $sql = 'SELECT slug FROM cook__choose';
        $command = Yii::app()->db->createCommand($sql);
        $models = $command->queryAll();

        $data = array();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'id' => $model['slug'],
                ),
            );
        }
        
        return $data;
    }

}