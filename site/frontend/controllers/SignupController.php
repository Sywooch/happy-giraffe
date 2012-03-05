<?php

class SignupController extends CController
{

	public $layout = 'signup';
	
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
	
	public function actionIndex()
	{
		$session = Yii::app()->session;
		$service = Yii::app()->request->getQuery('service');
		if (isset($service)) {
			$authIdentity = Yii::app()->eauth->getIdentity($service);
			$authIdentity->redirectUrl = $this->createAbsoluteUrl('signup/index');

			if ($authIdentity->authenticate()) {
				Yii::app()->user->setFlash('regdata', $authIdentity->getItemAttributes());
				$name = $authIdentity->getServiceName();
				$id = $authIdentity->getAttribute('id');
                $check = UserSocialService::model()->findByAttributes(array(
                    'service' => $name,
                    'service_id' => $id,
                ));
                if($check)
                {
                    $this->redirect(array('/site/login', 'service' => $service, 'register' => true));
                }
				$session['service'] = array(
					'name' => $name,
					'id' => $id,
				);
			}

			$authIdentity->redirect();
		}
		$regdata = Yii::app()->user->getFlash('regdata');
		
		$model = new User;
		
		$this->render('index', array(
			'model' => $model,
			'regdata' => $regdata,
		));
	}
	
	public function actionFinish()
	{
		$session = Yii::app()->session;
		$model = new User('signup');
	
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$current_service = $session['service'];
			if ($current_service)
			{
				$service = new UserSocialService;
				$service->setAttributes(array(
					'service' => $current_service['name'],
					'service_id' => $current_service['id'],
				));
				$model->social_services = array($service);
			}
			$model->register_date = date('Y-m-d H:i:s');
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
				unset($session['service']);
				$this->render('finish');
			}
		}
	}
	
	public function actionValidate($step)
	{
		$steps = array(
			array('first_name', 'password', 'email', 'verifyCode'),
			array('gender'),
		);
	
		$model = new User('signup');
		$model->setAttributes($_POST['User']);
		
		if ($model->validate($steps[$step - 1]))
		{
			$response = array(
				'status' => 'ok',
			);
		}
		else
		{
			$errors = $model->getErrors();
			$_errors = array();
			foreach ($errors as $attribute)
			{
				foreach ($attribute as $error)
				{
					$_errors[] = $error;
				}
			}
			$errors = $this->renderPartial('errors', array('errors' => $_errors), TRUE);
			$response = array(
				'status' => 'error',
				'errors' => $errors,
			);
		}
		echo CJSON::encode($response);
	}
	
}