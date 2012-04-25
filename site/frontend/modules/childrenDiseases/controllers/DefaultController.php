<?php
Yii::import('application.modules.recipeBook.models.RecipeBookDisease.php');
Yii::import('application.modules.recipeBook.models.RecipeBookDiseaseCategory.php');

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
                'select' => array('name')
            )
        ))->findAll(array(
                'order' => 't.name',
                'select' => array('id', 'name', 'slug', 'category_id'))
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
                'select' => array('name'),
            )
        ))->findByAttributes(array('slug' => $url));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = $model->name;
        $cat = RecipeBookDisease::model()->findAll(array(
            'order' => 't.name',
            'select' => array('id', 'name', 'slug'),
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
            'order' => 'name',
            'select' => array(
                'id',
                'name',
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
                'select' => array('name')
            )
        ))->findAll(
            array(
                'order' => 't.name',
                'select' => array('id', 'name', 'slug', 'category_id')
            )
        );
        $categoryList = RecipeBookDisease::GetDiseaseCategoryList($diseases);

        $this->renderPartial('category_list', array(
            'categoryList' => $categoryList
        ));
    }
}