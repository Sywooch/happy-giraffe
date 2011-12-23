<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionEdit($id = null)
	{
		if ($id === null)
		{
			$action = 'add';
			$model = new RecipeBookRecipe;
		}
		else
		{
			$action = 'edit';
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
				$model->save(false);
				if ($action == 'edit')
				{
					RecipeBookIngredient::model()->deleteAllByAttributes(array('recipe_id' => $model->id));
				}
				foreach ($ingredients as $ingredient)
				{
					$ingredient->recipe_id = $model->id;
					$ingredient->save(false);
				}
				if ($action == 'edit')
				{
					$model->refresh();
				}
			}
		}
		
		$this->render('_form', array(
			'model' => $model,
			'ingredients' => $ingredients,
		));
	}
	
	public function actionDiseases()
	{
		$model = new RecipeBookRecipe;
		$category_id = $_POST['disease_category'];
		
		$diseases = RecipeBookDisease::model()->findAllByAttributes(array('category_id' => $category_id));
		echo CHtml::activeDropDownList($model, 'disease_id', CHtml::listData($diseases, 'id', 'name'), array('prompt' => 'Выберите болезнь'));
	}
}