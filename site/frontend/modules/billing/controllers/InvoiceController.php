<?php

class InvoiceController extends HController
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('*'),
			//	'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('*'),
			//	'users'=>array('admin'),
			),
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
	public function actionCreate()
	{
		$model=new BillingInvoice('create');
		$model->unsetAttributes();

		if(isset($_POST['BillingInvoice'])) {
			$vars = $_POST['BillingInvoice'];
		} else if(!empty($_GET)) {
			foreach($_GET as $n=>$v) {
				if (strncmp($n, 'invoice_', 8) === 0) {
					$vars[$n] = $v;
				}
			}
		}

		if(isset($vars))
		{
			$model->attributes = $vars;
			if($model->validate()) {
				$model->invoice_time = time();
				$model->save(false);
				
				$pay=new BillingPayment('create');
				$pay->unsetAttributes();
				$pay->payment_invoice_id = $model->invoice_id;

				if (isset($_POST['BillingPayment']))
				{
					$pay->attributes = $_POST['BillingPayment'];
					$pay->payment_currency = $model->invoice_currency;
					$pay->payment_description = $model->invoice_description;
					$pay->payment_amount = $model->invoice_amount;
					$pay->payment_invoice_id = $model->invoice_id;
					if($pay->save()) {
						$systems = BillingSystem::enum('system_id,system_code');
						$this->redirect(
							array('pay/'.$systems[$pay->payment_system_id], 'payment_id'=>$pay->payment_id)
						);
					}
				}
				
				$this->redirect(array('pay/create', 'invoice_id'=>$model->invoice_id));
			}
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

		if(isset($_POST['BillingInvoice']))
		{
			$model->attributes=$_POST['BillingInvoice'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->invoice_id));
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('BillingInvoice');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new BillingInvoice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BillingInvoice']))
			$model->attributes=$_GET['BillingInvoice'];

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
		$model=BillingInvoice::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='billing-invoice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
