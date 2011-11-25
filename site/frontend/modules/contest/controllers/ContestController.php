<?php

class ContestController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/contest';
	public $contest;

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
				'actions'=>array('index','view','list','rules'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
//				'roles'=>array('admin'),
				'users'=>array('@'),
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
		$contest = Contest::model()->with(array(
			'prizes' => array('with' => 'product'),
			'works' => array('limit' => 15),
			'winners',
		))->findByPk($id);
		if ($contest === null) throw new CHttpException(404, 'Такого конкурса не существует.');
		
		$this->contest = $contest;
		
		$this->render('home', array(
			'contest' => $contest,
		));
	}
	
	public function actionList($id, $sort = 'work_time')
	{
		$contest = Contest::model()->with('winners')->findByPk($id);
		if ($contest === null) throw new CHttpException(404, 'Такого конкурса не существует.');
		
		$works = ContestWork::model()->get($id, $sort);
		
		$this->contest = $contest;
		
		$this->render('list', array(
			'contest' => $contest,
			'works' => $works->data,
			'pages' => $works->pagination,
			'sort' => $sort,
		));
	}
	
	public function actionRules($id)
	{
		$contest = Contest::model()->with('winners')->findByPk($id);
		if ($contest === null) throw new CHttpException(404, 'Такого конкурса не существует.');
		
		$this->contest = $contest;
		
		$this->render('rules', array(
			'contest' => $contest,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Contest;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Contest']))
		{
			$model->attributes=$_POST['Contest'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->contest_id));
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

		if(isset($_POST['Contest']))
		{
			$model->attributes=$_POST['Contest'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->contest_id));
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
		$this->layout = '//layouts/main';
		$contests = Contest::model()->findAll();
		$this->render('index', array(
			'contests' => $contests,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Contest('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Contest']))
			$model->attributes=$_GET['Contest'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 *
	 * @return Contest;
	 */
	public function loadModel($id)
	{
		$model=Contest::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='contest-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
