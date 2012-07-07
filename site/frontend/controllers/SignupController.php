<?php

class SignupController extends HController
{
    public function filters()
    {
        return array(
            'ajaxOnly + validate1',
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
			if($model->save(true, array('first_name', 'last_name', 'password', 'email', 'gender')))
			{
                /*Yii::app()->mc->sendToEmail($model->email, $model, 'user_registration');*/
				unset($session['service']);
                $identity = new UserIdentity($model->getAttributes());
                $identity->authenticate();
                Yii::app()->user->login($identity);
                $model->login_date = date('Y-m-d H:i:s');
                $model->last_ip = $_SERVER['REMOTE_ADDR'];
                $model->save(false);
                echo CJSON::encode(array(
                    'status' => true,
                    'profile'=>$model->getUrl()
                ));
                Yii::app()->end();
            }
        }
        echo CJSON::encode(array('status' => false));
    }

    public function actionValidate($step)
    {
        $steps = array(
            array('email'),
            array('first_name', 'last_name', 'password', 'gender', 'email'),
        );

        $model = new User('signup');
        $model->setAttributes($_POST['User']);

        echo CActiveForm::validate($model, $steps[$step - 1]);
    }
}