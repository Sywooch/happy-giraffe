<?php

class AttributeValueMapController extends HController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','admin','delete'),
				'users'=>array('*'),
			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$attribute = Attribute::model()->findByPk((int)$id);
		if(!$attribute)
			throw new CHttpException(404,'The requested page does not exist.');

		$model=new AttributeValue;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['AttributeValue']))
		{
			$model->attributes=$_POST['AttributeValue'];
			if(($value_id = $model->findOrSave()))
			{
				$map = new AttributeValueMap;
				$map->map_attribute_id = $id;
				$map->map_value_id = $value_id;
				if($map->save())
					$this->redirect(array('/attribute/attribute/view','id'=>$attribute->attribute_id));
			}
		}

		if(Y::isAjaxRequest())
			$this->layout = '//layouts/empty';

		$this->render('/attributeValue/create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$vid)
	{
		$map=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model=AttributeValue::model()->findByPk((int)$vid);
		if(!$model)
			throw new CHttpException(404,'The requested page does not exist.');


		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['AttributeValue']))
		{
			$model->attributes=$_POST['AttributeValue'];
			if(($value_id = $model->findOrSave()))
				$this->redirect(array('/attribute/attribute/view','id'=>$map->map_attribute_id));
		}

		if(Y::isAjaxRequest())
			$this->layout = '//layouts/empty';

		$this->render('/attributeValue/update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id, $vid)
	{
		$map=$this->loadModel($id);

		$map_attribute_id = $map->map_attribute_id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$map->delete();

		$this->redirect(array('/attribute/attribute/view','id'=>$map_attribute_id));

//		if(Yii::app()->request->isPostRequest)
//		{
//			// we only allow deletion via POST request
//			$this->loadModel($id)->delete();
//
//			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//			if(!isset($_GET['ajax']))
//				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//		}
//		else
//			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('AttributeValueMap');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AttributeValueMap('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AttributeValueMap']))
			$model->attributes=$_GET['AttributeValueMap'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return AttributeValueMap
	 */
	public function loadModel($id)
	{
		$model=AttributeValueMap::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && ($_POST['ajax']==='product-attribute-value-map-form' || $_POST['ajax']==='product-attribute-value-form'))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
