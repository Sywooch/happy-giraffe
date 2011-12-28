<?php

class DefaultController extends Controller
{
	public $layout = '//layouts/main';

	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionEdit($id = null)
	{
		if ($id === null)
		{
			$model = new RecipeBookRecipe;
		}
		else
		{
			$model = RecipeBookRecipe::model()->with(array('disease.category.diseases', 'purposes', 'ingredients'))->findByPk($id);
			if ($model === null)
			{
				throw new CHttpException(404, 'Такой записи не существует.');
			}
		}
		
		$ingredients = array();
		if (isset($_POST['RecipeBookRecipe'], $_POST['RecipeBookIngredient']))
		{
			$model->attributes = $_POST['RecipeBookRecipe'];
			$model->purposes = $model->purposeIds;
			$valid = $model->validate();
		
			foreach ($_POST['RecipeBookIngredient'] as $i)
			{
				$ingredient = new RecipeBookIngredient;
				$ingredient->attributes = $i;
				$valid = $ingredient->validate() && $valid;
				$ingredients[] = $ingredient;
			}
			
			if ($valid)
			{
				$isNewRecord = $model->isNewRecord;
				$model->save(false);
				if (! $isNewRecord)
				{
					RecipeBookIngredient::model()->deleteAllByAttributes(array('recipe_id' => $model->id));
				}
				foreach ($ingredients as $ingredient)
				{
					$ingredient->recipe_id = $model->id;
					$ingredient->save(false);
				}
				if (! $isNewRecord)
				{
					$model->refresh();
				}
			}
		}
		
		$this->render('edit', array(
			'model' => $model,
			'ingredients' => $ingredients,
		));
	}
	
	public function actionDiseases()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$model = new RecipeBookRecipe;
			$category_id = $_POST['disease_category'];
		
			$diseases = RecipeBookDisease::model()->findAllByAttributes(array('category_id' => $category_id));
			echo CHtml::activeDropDownList($model, 'disease_id', CHtml::listData($diseases, 'id', 'name'), array('prompt' => 'Выберите болезнь'));
		}
	}
}