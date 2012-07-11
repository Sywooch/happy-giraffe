<?php

class RecipeBookDiseaseCategoryController extends BController
{
	public $defaultAction='admin';
    public $section = 'club';
    public $layout = '//layouts/club';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('editRecipeBook'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new RecipeBookDiseaseCategory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RecipeBookDiseaseCategory']))
		{
			$model->attributes=$_POST['RecipeBookDiseaseCategory'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RecipeBookDiseaseCategory']))
		{
			$model->attributes=$_POST['RecipeBookDiseaseCategory'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new RecipeBookDiseaseCategory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RecipeBookDiseaseCategory']))
			$model->attributes=$_GET['RecipeBookDiseaseCategory'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=RecipeBookDiseaseCategory::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='recipe-book-disease-category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionAddPhoto()
    {
        $id = Yii::app()->request->getPost('id');
        $product = $this->loadModel($id);

        if (!empty($product->photo))
            $last_photo = $product->photo;

        if (isset($_FILES['photo']) && !empty($product)) {
            $file = CUploadedFile::getInstanceByName('photo');
            if (!in_array($file->extensionName, array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF')))
                Yii::app()->end();

            $photo = new AlbumPhoto();
            $photo->file = $file;
            $photo->title = $product->title;
            $photo->author_id = 1;

            if ($photo->create()) {
                echo "<script type='text/javascript'>
                document.domain = document.location.host;
                </script>";

                $product->photo_id = $photo->id;
                if ($product->save()) {
                    if (isset($last_photo))
                        $last_photo->delete();
                    $response = array(
                        'status' => true,
                        'image' => $photo->getPreviewUrl()
                    );
                } else
                    $response = array('status' => false);
            } else
                $response = array('status' => false);

            echo CJSON::encode($response);
        }
    }
}
