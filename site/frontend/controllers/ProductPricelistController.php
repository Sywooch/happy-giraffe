<?php

class ProductPricelistController extends HController
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
				'actions' => array('create', 'update', 'admin', 'delete', 'settings', 'ajaxSets','mapDelete','products','createBy','file'),
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
	
	public function actionFile()
	{
		Y::endJson(array('msg'=>'ok'));
	}


	public function actionCreateBy($id=null)
	{
		$model = new ProductPricelist('by');
		$model->pricelist_by = $id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProductPricelist']))
		{
			$model->attributes = $_POST['ProductPricelist'];
			if($model->save())
				$this->redirect(array('admin', 'id' => $model->pricelist_id));
		}

		$this->render('createBy', array(
			'model' => $model,
		));
	}


	public function actionProducts($id, $pid)
	{
		$product = ProductPricelistSetMap::model()->getProductBySetMapId($id, $pid);
		if($product)
			Y::endJson(array_merge($product, array('msg'=>'ok')));
		
		Y::endJson(array('msg'=>'No such prodyct'));
	}

	public function actionSettings($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$map = new ProductPricelistSetMap;
		$this->performAjaxValidation($map);

		if(isset($_POST['ProductPricelistSetMap']))
		{
			if(isset ($_POST['ProductPricelistSetMap']['map_id']) && $_POST['ProductPricelistSetMap']['map_id'])
			{
				$map = ProductPricelistSetMap::model()->findByPk((int) $_POST['ProductPricelistSetMap']['map_id']);
			}
			
			if(!$map)
				$map = new ProductPricelistSetMap;
			
			
			$map->attributes = $_POST['ProductPricelistSetMap'];
			if(!$map->save())
				Y::errorFlash('Error save this set');
			else
				$map->unsetAttributes();
		}

		$map->map_pricelist_id = (int) $id;
		$maps = CHtml::listData(ProductPricelistSetMap::model()->getByMapPricelistId((int)$id), 'map_product_id', 'map_product_id');
		
		$criteria = new CDbCriteria;
		$criteria->addInCondition('product_id', $maps);

		$products = new Product('search');
		$products->unsetAttributes();  // clear any default values
		if(isset($_GET['Product']))
			$products->attributes = $_GET['Product'];

		$this->render('settings', array(
			'model'=>$model,
			'products'=>$products,
			'criteria'=>$criteria,
			'map'=>$map,
		));
	}

	/**
	 *
	 * @param int $id pricelist ID
	 * @param string $term search text
	 */
	public function actionAjaxSets($id, $term='')
	{
		if($exist_product_ids)
			$exist_product_ids = CHtml::listData(ProductPricelistSetMap::model()->getByMapPricelistId((int)$id), 'map_product_id', 'map_product_id');

		$criteria = new CDbCriteria;
		if($term)
			$criteria->compare('set_title', $term, true);
		if($exist_product_ids)
			$criteria->addNotInCondition('product_id', $exist_product_ids);

		$sets = Product::model()->listAll('product_title', $criteria);

		$result = array();
		if($sets)
		{
			foreach($sets as $id=>$set)
			{
				$result[] = array(
					'id'=>$id,
					'value'=>$set,
					'label'=>$set,
				);
			}
		}
		else
		{
			$result[] = array(
				'id'=>0,
				'value'=>'No set found',
				'label'=>'No set found',
			);
		}

		Y::endJson($result);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new ProductPricelist;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProductPricelist']))
		{
			$model->attributes = $_POST['ProductPricelist'];
			if($model->save())
				$this->redirect(array('admin', 'id' => $model->pricelist_id));
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

		if(isset($_POST['ProductPricelist']))
		{
			$model->attributes = $_POST['ProductPricelist'];
			if($model->save())
				$this->redirect(array('admin', 'id' => $model->pricelist_id));
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
		$model = new ProductPricelist('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ProductPricelist']))
			$model->attributes = $_GET['ProductPricelist'];

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
		$model = ProductPricelist::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && in_array($_POST['ajax'], array('product-pricelist-form', 'product-set-form')))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionMapDelete($sid, $pid)
	{
		if(Yii::app()->request->isPostRequest)
		{
			ProductPricelistSetMap::model()->deleteAll('map_product_id=:map_product_id AND map_pricelist_id=:map_pricelist_id', array(
				':map_product_id' => (int)$sid,
				':map_pricelist_id' => (int)$pid,
			));
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

}
