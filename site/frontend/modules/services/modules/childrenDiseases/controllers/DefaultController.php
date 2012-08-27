<?php

class DefaultController extends HController
{
    public $layout = 'desease';
    public $pageTitle = 'Справочник детских болезней';
    public $category_id = 0;

    public function actionIndex()
    {
        $categories = RecipeBookDiseaseCategory::model()->findAll();

        $this->render('index', array(
            'categories' => $categories
        ));
    }

    /**
     * @sitemap dataSource=getDiseasesUrls
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        if ($model == null) {
            $model = $this->loadCategory($id);
            if ($model === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $this->category_id = $model->id;
            $this->pageTitle = $model->title;
            $this->render('category', compact('model'));
        } else {

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

    public function getDiseasesUrls()
    {
        $models = Yii::app()->db->createCommand()
            ->select('id')
            ->from('recipe_book__diseases')
            ->queryAll();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'slug' => $model['id'],
                ),
                'priority' => 0.5,
            );
        }
        return $data;

    }
}