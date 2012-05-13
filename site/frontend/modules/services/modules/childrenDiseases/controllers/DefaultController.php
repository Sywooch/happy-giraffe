<?php

class DefaultController extends HController
{
    public $layout = 'desease';
    public $index = false;
    public $pageTitle = 'Справочник детских болезней';

    public function actionIndex()
    {
        $this->index = true;
        $diseases = RecipeBookDisease::model()->with(array(
            'category' => array(
                'select' => array('title')
            )
        ))->findAll(array(
                'order' => 't.title',
                'select' => array('id', 'title', 'slug', 'category_id'))
        );
        $alphabetList = RecipeBookDisease::GetDiseaseAlphabetList($diseases);
        $categoryList = RecipeBookDisease::GetDiseaseCategoryList($diseases);

        $this->render('index', array(
            'alphabetList' => $alphabetList,
            'categoryList' => $categoryList
        ));
    }

    public function actionView($url)
    {
        $model = RecipeBookDisease::model()->with(array(
            'category' => array(
                'select' => array('title'),
            )
        ))->findByAttributes(array('slug' => $url));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = $model->title;
        $cat = RecipeBookDisease::model()->findAll(array(
            'order' => 't.title',
            'select' => array('id', 'title', 'slug'),
            'condition' => 'category_id=' . $model->category_id
        ));

        $this->render('view', array(
            'model' => $model,
            'cat' => $cat
        ));
    }

    public function actionGetAlphabetList()
    {
        $diseases = RecipeBookDisease::model()->findAll(array(
            'order' => 'title',
            'select' => array(
                'id',
                'title',
                'slug'
            ),
        ));
        $alphabetList = RecipeBookDisease::GetDiseaseAlphabetList($diseases);

        $this->renderPartial('alphabet_list', array(
            'alphabetList' => $alphabetList,
        ));
    }

    public function actionGetCategoryList()
    {
        $diseases = RecipeBookDisease::model()->with(array(
            'category' => array(
                'select' => array('title')
            )
        ))->findAll(
            array(
                'order' => 't.title',
                'select' => array('id', 'title', 'slug', 'category_id')
            )
        );
        $categoryList = RecipeBookDisease::GetDiseaseCategoryList($diseases);

        $this->renderPartial('category_list', array(
            'categoryList' => $categoryList
        ));
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