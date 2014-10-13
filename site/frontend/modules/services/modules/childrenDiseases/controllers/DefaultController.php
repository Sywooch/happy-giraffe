<?php

class DefaultController extends LiteController
{

    public $category_id = 0;

    public function init()
    {
        $service = Service::model()->findByPk(2);
        $service->userUsedService();

        parent::init();

        $this->pageTitle = 'Справочник детских болезней';
    }

    public function beforeAction($action)
    {
        $package = Yii::app()->user->isGuest ? 'lite_diseases' : 'lite_diseases_user';
        Yii::app()->clientScript->registerPackage($package);
        Yii::app()->clientScript->useAMD = true;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $categories = RecipeBookDiseaseCategory::model()->cache(3600)->with(array('diseases'))->findAll();

        $this->render('index', array(
            'categories' => $categories
        ));
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        if ($model == null)
        {
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        }
        else
        {
            $this->category_id = $model->category_id;
            $this->pageTitle = $model->title;

            $this->render('view', array(
                'model' => $model,
            ));
        }
    }

    /**
     * @param int $id model id
     * @return RecipeBookDisease
     */
    public function loadModel($id)
    {
        $model = RecipeBookDisease::model()->with('category')->findByAttributes(array('slug' => $id));
        return $model;
    }

    /**
     * @param int $id model id
     * @return RecipeBookDiseaseCategory
     */
    public function loadCategory($id)
    {
        $model = RecipeBookDiseaseCategory::model()->findByAttributes(array('slug' => $id));
        return $model;
    }

    public function sitemapView()
    {
        $models = Yii::app()->db->createCommand()
            ->select('slug')
            ->from('recipe_book__diseases')
            ->queryAll();

        $data = array();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'id' => $model['slug'],
                ),
                'priority' => 0.5,
            );
        }

        return $data;
    }

}