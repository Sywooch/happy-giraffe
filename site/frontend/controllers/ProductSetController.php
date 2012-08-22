<?php

class ProductSetController extends HController
{

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

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
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('create', 'update', 'admin', 'delete', 'products', 'add', 'sub', 'psearch'),
				'users' => array('*'),
			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionProducts($id)
	{
		$products = ProductSetMap::model()->getProductsBySetId($id);
		foreach($products as $k => $v)
			$products[$k]['product_image'] = UFiles::getFileInstance($v['product_image']);

		$dataProvider = new CArrayDataProvider($products, array(
				'id' => 'products',
				'pagination' => array(
					'pageSize' => 100,
				),
			));

		if(Y::isAjaxRequest())
			$this->layout = 'empty';

		$this->render('products', array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionSub($id)
	{
		$map = ProductSetMap::model()->findByPk((int)$id);

		if($map)
		{
			$map_set_id = $map->map_set_id;
			$map->delete();
			if(Y::isAjaxRequest())
				Y::end('Map delete successfyly.');
			else
			{
				Y::successFlash('Map delete successfyly.');
				$this->redirect(array('update', 'id' => $map_set_id));
			}
		}

		if(Y::isAjaxRequest())
			Y::end('Map not found.');
		else
		{
			Y::errorFlash('Map not found.');
			$this->redirect(array('update', 'id' => $map_set_id));
		}

	}

	public function actionAdd($id)
	{
		$model = new ProductSetMap;
		$model->map_set_id = $id;

		$this->performAjaxValidation($model);

		if(isset($_POST['ProductSetMap']))
		{
			$model->attributes = $_POST['ProductSetMap'];
			if($model->save())
			{
				if(Y::isAjaxRequest())
					Y::end('Product save successfyly.');
				else
					$this->redirect(array('update', 'id' => $model->map_set_id));
			}
		}

		if(Y::isAjaxRequest())
			$this->layout = 'empty';

		$this->render('add', array(
			'model' => $model,
		));
	}

	public function actionPsearch($term)
	{
		$products = Product::model()->listsAll($term,'product_id, product_title, product_image');
		$json = array();
		foreach($products as $k => $v)
		{
			$json[$k]['img'] = UFiles::getFileInstance($v['product_image'])->getUrl('thumb');
			$json[$k]['label'] = $v['product_title'];
			$json[$k]['id'] = $v['product_id'];
		}

		Y::endJson($json);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new ProductSet;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProductSet']))
		{
			$model->attributes = $_POST['ProductSet'];
			if($model->save())
				$this->redirect(array('admin', 'id' => $model->set_id));
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProductSet']))
		{
			$model->attributes = $_POST['ProductSet'];
			if($model->save())
				$this->redirect(array('admin', 'id' => $model->set_id));
		}

		$this->render('update', array(
			'model' => $model,
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
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new ProductSet('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ProductSet']))
			$model->attributes = $_GET['ProductSet'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = ProductSet::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'product-set-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
