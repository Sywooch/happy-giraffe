<?php

class CompetitionController extends HController
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
				'actions'=>array('index','view','all','rating','refreshRate'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create'),
				'users'=>array('@'),
			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete','grub'),
//				'roles'=>array('admin'),
//			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	private function calculateRating($id)
	{
		$rate = 0;
		$thisModel = $this->loadModel($id);
		$url = $this->createAbsoluteUrl('competition/view', array(id => $id));

		$ch = curl_init();
		$text = file_get_contents('http://connect.mail.ru/share_count?url_list='.$url);
		$array = json_decode($text, true);
		$rate += intval($array[$url]['shares']);

		$text = file_get_contents('http://www.odnoklassniki.ru/dk?st.cmd=extLike&uid=odklcnt0&ref='.$url);
		$text = explode("'", $text);
		$rate += intval($text[3]);

		$vk = new Vkapi(2414760, 'Q0iTqPWBlTSF8SeylJ1m');
		$resp = $vk->api('likes.getList', array(
			'type'=>'sitepage',
			'owner_id'=>2414760,
			'page_url'=>$url,
			'count'=>1,
		));
		$rate += $resp['response']['count'];

		$thisModel->rating = $rate;
		$thisModel->save(false);

		return $rate;
	}

	public function actionRefreshRate()
	{
		echo $this->calculateRating($_REQUEST['id']);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->layout = 'frontend_club_competition';
		$this->calculateRating($id);

		$thisModel = $this->loadModel($id);

		$this->pageTitle = $thisModel->title;

		//next and previous ids
		$next_id = false;
		$prev_id = false;
		$criteria=new CDbCriteria(array(
			'condition'=>'(status > '.Photo::STATUS_BLOCKED.') AND (create_time>'.$thisModel->create_time.')',
			'order'=>'create_time ASC',
		));
		if ($model = Photo::model()->find($criteria))
			$next_id = $model->id;
		$criteria=new CDbCriteria(array(
			'condition'=>'(status > '.Photo::STATUS_BLOCKED.') AND (create_time<'.$thisModel->create_time.')',
			'order'=>'create_time DESC',
		));
		if ($model = Photo::model()->find($criteria))
			$prev_id = $model->id;

		//load comments
		$criteria=new CDbCriteria(array(
			'condition'=>'(status > '.PhotoComment::STATUS_BLOCKED.') AND (post_id = '.$thisModel->id.')',
			'order'=>'create_time ASC',
			'with'=>'author',
		));
		$commentsCount = PhotoComment::model()->count($criteria);
		$criteria->limit = 50;
		$comments = PhotoComment::model()->findAll($criteria);
		$moreComments = (($commentsCount > $criteria->limit)?true:false);

		//render
		$this->render('view',array(
			'data'=>$thisModel,
			'next_id'=>$next_id,
			'prev_id'=>$prev_id,
			'this_id'=>$id,
			'comments'=>$comments,
			'moreComments'=>$moreComments,
		));

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Photo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST))
		{
			$model->attributes=$_POST['Photo'];
            $model->url = CUploadedFile::getInstance($model,'url');
			if ($model->save())
			{
				if (!is_null($model->url))
				{
					$name = md5(time().$model->url->getName());
					$logoFileName = 'img/uploads/Photo/'.$name.'.'.$model->url->getExtensionName();
					$model->url->saveAs($logoFileName);
					$thumbFileName = 'img/uploads/Photo/'.$name.'_thumb.'.$model->url->getExtensionName();
					$image = Yii::app()->image->load($logoFileName);
					$image->resize(239, 180);
					$image->save($thumbFileName);
					$model->url = '/'.$logoFileName;
					$model->thumb = '/'.$thumbFileName;
					$model->save();
				}
			}
		}

		$this->redirect(array('index'));
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

		if(isset($_POST['ClubPost']))
		{
			$model->attributes=$_POST['ClubPost'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
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

	public function actionIndex()
	{
		$this->layout = 'frontend_club_competition';
		
		$criteria=new CDbCriteria(array(
			'condition'=>'status > '.ClubPost::STATUS_BLOCKED,
			'order'=>'create_time DESC',
			'with'=>array('commentCount', 'author'),
		));
		$count=Photo::model()->count($criteria);

		$criteria->limit = 9;
		$models = Photo::model()->findAll($criteria);

		$this->render('index', array(
			'models' => $models,
			'count' => $count,
		));
	}

	public function actionRating()
	{
		$this->layout = 'frontend_club_competition';

		$criteria=new CDbCriteria(array(
			'condition'=>'status > '.ClubPost::STATUS_BLOCKED,
			'order'=>'rating DESC',
			'with'=>array('commentCount', 'author'),
		));
		$count=Photo::model()->count($criteria);

		$criteria->limit = 12;
		$models = Photo::model()->findAll($criteria);

		$this->render('rating', array(
			'models' => $models,
			'count' => $count,
		));
	}
	
	public function actionAll()
	{
		$this->layout = 'frontend_club_competition';

		$criteria=new CDbCriteria(array(
			'condition'=>'status > '.ClubPost::STATUS_BLOCKED,
			'order'=>'create_time DESC',
			'with'=>array('commentCount', 'author'),
		));
		$count=Photo::model()->count($criteria);

		$pages=new CPagination($count);
		// элементов на страницу
		$pages->pageSize=15;
		$pages->applyLimit($criteria);

		$models = Photo::model()->findAll($criteria);

		$this->render('all', array(
			'models' => $models,
			'count' => $count,
			'pages' => $pages,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ClubPost('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ClubPost']))
			$model->attributes=$_GET['ClubPost'];

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
		$model=Photo::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='club-post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
