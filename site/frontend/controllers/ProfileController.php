<?php

class ProfileController extends Controller
{

	public $user;
	
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CaptchaAction',
				'backColor'=>0xFFFFFF,
				'width' => 125,
				'height' => 46,
				'onlyDigits' => TRUE,
			),
		);
	}

	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'users' => array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public $layout = '//layouts/profile';

	protected function beforeAction($action)
	{
		$this->user = User::model()->with('settlement')->findByPk(Yii::app()->user->id);
		return true;
	}

	public function actionIndex()
	{
		$regions = GeoRusRegion::model()->findAll();
		$_regions = array('' => '---');
		foreach ($regions as $r)
		{
			$_regions[$r->id] = $r->name;
		}
		
		$current_region = ($this->user->settlement) ? $this->user->settlement->region->id : null;
	
		if(isset($_POST['User']))
		{
			$this->user->attributes = $_POST['User'];
			$this->user->save(true, array('last_name', 'first_name', 'gender', 'email', 'settlement_id', 'birthday'));
		}
		
		$this->render('data', array(
			'regions' => $_regions,
			'current_region' => $current_region,
		));
	}
	
	public function actionPhoto()
	{
		print_r($_POST);
	
		if(isset($_POST['User']))
		{
			$this->user->attributes = $_POST['User'];
			$this->user->save(true, array('pic_small'));
		}
	
		$this->render('photo');
	}
	
	public function actionFamily()
	{
		$this->render('family');
	}
	
	public function actionAccess()
	{
		$this->render('access');
	}
	
	public function actionBlacklist()
	{
		$this->render('blacklist');
	}

	public function actionSubscription()
	{
		$this->render('subscription');
	}
	
	public function actionSocials()
	{
		$this->render('socials');
	}
	
	public function actionPassword()
	{
		$this->user->scenario = 'change_password';
		
		if(isset($_POST['User']))
		{
			$this->user->attributes = $_POST['User'];
			if ($this->user->validate(array('current_password', 'new_password', 'new_password_repeat', 'verifyCode')))
			{
				$this->user->password = $this->user->new_password;
				$this->user->save(true, array('password'));
			}
		}
	
		$this->render('password', array(
			'user' => $this->user,
		));
	}


}