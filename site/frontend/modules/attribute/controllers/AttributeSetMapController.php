<?php

class AttributeSetMapController extends HController
{
	/**
	 * @var string the default layout for the views_old. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views_old/layouts/column2.php'.
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$pas = new AttributeSet;

		if(!Y::command()->select('set_id')->from($pas->tableName())->where('set_id=:set_id', array(
			':set_id'=>$id,
		))->queryScalar())
			throw new CHttpException(404,'The requested page does not exist.');

		$model=new AttributeSetMap;
		$model->map_set_id = (int) $id;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['AttributeSetMap']))
		{
			$model->attributes=$_POST['AttributeSetMap'];
			if($model->save())
				$this->redirect(array('/attribute/attributeSet/view','id'=>$id));
		}

		$pa = new Attribute;

		$attributes = Y::command()
			->select('attribute_id AS id, attribute_title AS val')
			->from($pa->tableName())
			->queryAll();

		$attributes = Y::listData($attributes);

		if(Y::isAjaxRequest())
			$this->layout = '//layouts/empty';

		$this->render('create',array(
			'model'=>$model,
			'attributes'=>$attributes,
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
		$this->performAjaxValidation($model);

		if(isset($_POST['AttributeSetMap']))
		{
			$model->attributes=$_POST['AttributeSetMap'];
			if($model->save())
				$this->redirect(array('/attribute/attributeSet/view','id'=>$model->map_set_id));
		}

		$pa = new Attribute;

		$attributes = Y::command()
			->select('attribute_id AS id, attribute_title AS val')
			->from($pa->tableName())
			->queryAll();

		$attributes = Y::listData($attributes);

		if(Y::isAjaxRequest())
			$this->layout = '//layouts/empty';

		$this->render('update',array(
			'model'=>$model,
			'attributes'=>$attributes,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
//		if(Yii::app()->request->isPostRequest)
//		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//		}
//		else
//			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('AttributeSetMap');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AttributeSetMap('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AttributeSetMap']))
			$model->attributes=$_GET['AttributeSetMap'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return AttributeSetMap
	 */
	public function loadModel($id)
	{
		$model=AttributeSetMap::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-attribute-set-map-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
