<?php

class Signup2Controller extends HController
{
    public function filters()
    {
        return array(
            'ajaxOnly + Validate',
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
                if ($check) {
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
			if($model->save(true, array('first_name', 'password', 'email', 'gender')))
			{
                /*Yii::app()->mc->sendToEmail($model->email, $model, 'user_registration');*/
				unset($session['service']);
                $identity = new UserIdentity($model->getAttributes());
                $identity->authenticate();
                Yii::app()->user->login($identity);
                $model->login_date = date('Y-m-d H:i:s');
                $model->last_ip = $_SERVER['REMOTE_ADDR'];
                $model->save(false);
                if (!Yii::app()->request->getQuery('redirectUrl') || Yii::app()->request->getQuery('redirectUrl') == '')
                    $this->redirect(array('/user/profile', 'user_id' => $model->id));
                else
                    $this->redirect(array(urldecode(Yii::app()->request->getQuery('redirectUrl'))));
            }
        }
    }

    public function actionValidate()
    {
        $model = new User('signup');
        $model->setAttributes($_POST['User']);

        echo CActiveForm::validate($model, array('first_name', 'password', 'email', 'gender'));
    }

}