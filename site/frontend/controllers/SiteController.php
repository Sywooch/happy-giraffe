<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionRegister()
	{
		$session = Yii::app()->session;
		$service = Yii::app()->request->getQuery('service');
		if (isset($service)) {
			$authIdentity = Yii::app()->eauth->getIdentity($service);
			$authIdentity->redirectUrl = $this->createAbsoluteUrl('site/register');

			if ($authIdentity->authenticate()) {
				Yii::app()->user->setFlash('regdata', $authIdentity->getItemAttributes());
				$name = $authIdentity->getServiceName();
				$id = $authIdentity->getAttribute('id');
				$session['service'] = array(
					'name' => $name,
					'id' => $id,
				);
			}

			$authIdentity->redirect();
		}
		$regdata = Yii::app()->user->getFlash('regdata');

		$model=new User(User::SCENARIO_SIGNUP);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$current_service = $session['service'];
			if ($current_service)
			{
				$model->password = '123456';
				$service = new UserSocialService;
				$service->setAttributes(array(
					'service' => $current_service['name'],
					'service_id' => $current_service['id'],
				));
				$model->social_services = array($service);
			}

			if($model->save())
			{
				foreach ($_POST['age_group'] as $k => $q)
				{
					for ($j = 0; $j < $q; $j++)
					{
						$baby = new Baby;
						$baby->age_group = $k;
						$baby->parent_id = $model->id;
						$baby->save();
					}
				}
				$this->redirect(array('site/index'));
			}
		}

		$this->render('register',array(
			'model'=>$model,
			'regdata' => $regdata,
		));
	}

	/**
	 * @sitemap
	 */

	public function actionIndex()
	{
		$this->pageTitle = 'Веселый Жираф - сайт для всей семьи';
		Yii::app()->clientScript->registerMetaTag('NWGWm2TqrA1HkWzR8YBwRT08wX-3SRzeQIBLi1PMK9M', 'google-site-verification');
		Yii::app()->clientScript->registerMetaTag('41ad6fe875ade857', 'yandex-verification');
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$service = Yii::app()->request->getQuery('service');
		if (isset($service)) {
			$authIdentity = Yii::app()->eauth->getIdentity($service);
			$authIdentity->redirectUrl = Yii::app()->user->returnUrl;

			if ($authIdentity->authenticate()) {
				$name = $authIdentity->getServiceName();
				$id = $authIdentity->getAttribute('id');
				$check = UserSocialService::model()->findByAttributes(array(
					'service' => $name,
					'service_id' => $id,
				));
				if ($check)
				{
					$user = User::model()->findByPk($check->user_id);
					$identity = new UserIdentity($user->getAttributes());
					$identity->authenticate();
					if ($identity->errorCode == UserIdentity::ERROR_NONE)
					{
						Yii::app()->user->login($identity);
                        $user->login_date = date('Y-m-d H:i:s');
                        $user->save(false);
						$authIdentity->redirect();
					}
				}
			}

			$authIdentity->redirect();
		}

		$userModel = new User('login');

		$this->performAjaxValidation($userModel);

		if (isset($_POST['User']))
		{
			$userModel = $userModel->find(array(
				'condition' => 'email=:email AND password=:password',
				'params'=>array(
					':email'=>$_POST['User']['email'],
					':password'=>$userModel->hashPassword($_POST['User']['password']),
				)));

			if ($userModel)
			{
				$identity=new UserIdentity($userModel->getAttributes());
				$identity->authenticate();
				if ($identity->errorCode == UserIdentity::ERROR_NONE)
				{
					Yii::app()->user->login($identity);
                    $userModel->login_date = date('Y-m-d H:i:s');
                    $userModel->last_ip = $_SERVER['REMOTE_ADDR'];
                    $userModel->save(false);
				}
			}
		}

		$this->redirect(Yii::app()->request->urlReferrer);
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->request->urlReferrer);
	}

	public function actionProfile()
	{
		$service = Yii::app()->request->getQuery('service');
		if (isset($service)) {
			$authIdentity = Yii::app()->eauth->getIdentity($service);
			$authIdentity->redirectUrl = $this->createAbsoluteUrl('site/profile/#yw6_tab_2');

			if ($authIdentity->authenticate()) {
				$name = $authIdentity->getServiceName();
				$id = $authIdentity->getAttribute('id');
				$service = new UserSocialService;
				$service->service = $name;
				$service->service_id = $id;
				$service->user_id = Yii::app()->user->id;
				$service->save();
			}

			//$authIdentity->redirect();
		}

		$user = User::model()->with('babies', 'settlement', 'social_services')->findByPk(Yii::app()->user->getId());
		$babies = array(
			array('label' => 'Ждем ребенка', 'content' => array()),
			array('label' => 'Дети в возрасте от 0 до 1', 'content' => array()),
			array('label' => 'Дети в возрасте от 1 до 3', 'content' => array()),
			array('label' => 'Дети в возрасте от 3 до 7', 'content' => array()),
			array('label' => 'Дети в возрасте от 7 до 18', 'content' => array()),
		);
		foreach ($user->babies as $b)
		{
			$babies[$b->age_group]['content'][] = $b;
		}
		$regions = GeoRusRegion::model()->findAll();
		$_regions = array('' => '---');
		foreach ($regions as $r)
		{
			$_regions[$r->id] = $r->name;
		}
		$this->render('profile', array(
			'model' => $user,
			'babies' => $babies,
			'regions' => $_regions,
		));
	}

	public function actionEmptyCache()
	{
		Y::cache()->flush();
		$this->redirect('/shop/');
	}

	public function actionMap()
	{
		$contents = CommunityContent::model()->with('rubric.community', 'type')->findAll();

		$this->render('map', array(
			'contents' => $contents,
		));
	}
}