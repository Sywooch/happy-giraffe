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

    public function actionCategory($id){
        $model = $this->loadCategory($id);
        $this->category_id = $model->id;

        $this->render('category', compact('model'));
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->category_id = $model->category_id;
        $this->pageTitle = $model->title;

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * @param int $id model id
     * @return RecipeBookDisease
     * @throws CHttpException
     */
    public function loadModel($id){
        $model = RecipeBookDisease::model()->with('category')->findByAttributes(array('slug' => $id));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        return $model;
    }

    /**
     * @param int $id model id
     * @return RecipeBookDiseaseCategory
     * @throws CHttpException
     */
    public function loadCategory($id){
        $model = RecipeBookDiseaseCategory::model()->findByAttributes(array('slug' => $id));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function actionTest(){
        $diseases = RecipeBookDisease::model()->findAll();
        foreach($diseases as $disease){
            $disease->slug = str_replace(' ', '_', $disease->slug);
            $disease->slug = str_replace('+', '_', $disease->slug);
            $disease->slug = str_replace('-', '_', $disease->slug);
            $disease->slug = str_replace('\'', '', $disease->slug);
            $disease->save();
        }
    }
}