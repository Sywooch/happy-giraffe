<?php
Yii::import('application.modules.recipeBook.models.RecipeBookDisease.php');
Yii::import('application.modules.recipeBook.models.RecipeBookDiseaseCategory.php');

class DefaultController extends Controller
{
    public $layout = 'desease';

	public function actionIndex()
	{
        $diseases = RecipeBookDisease::model()->findAll(array('order'=>'name','select'=>array('id','name','slug','category_id')));
        $alphabetList = RecipeBookDisease::GetDiseaseAlphabetList($diseases);
        $categoryList = RecipeBookDisease::GetDiseaseCategoryList($diseases);

		$this->render('index',array(
            'alphabetList'=>$alphabetList,
            'categoryList'=>$categoryList
        ));
	}

    public function actionView($url){
        $model = RecipeBookDisease::model()->findByAttributes(array('slug'=>$url));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        $cat = RecipeBookDisease::model()->findAll(array(
            'order'=>'name',
            'select'=>array('id','name','slug'),
            'condition'=>'category_id='.$model->category_id
        ));

        $this->render('view',array(
            'model'=>$model,
            'cat'=>$cat
        ));
    }

    public function actionGetAlphabetList(){
        $diseases = RecipeBookDisease::model()->findAll(array('order'=>'name','select'=>array('id','name','slug')));
        $alphabetList = RecipeBookDisease::GetDiseaseAlphabetList($diseases);

        $this->renderPartial('alphabet_list',array(
            'alphabetList'=>$alphabetList,
        ));
    }

    public function actionGetCategoryList(){
        $diseases = RecipeBookDisease::model()->findAll(array('order'=>'name','select'=>array('id','name','slug','category_id')));
        $categoryList = RecipeBookDisease::GetDiseaseCategoryList($diseases);

        $this->renderPartial('category_list',array(
            'categoryList'=>$categoryList
        ));
    }
}