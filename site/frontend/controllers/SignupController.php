<?php

class SignupController extends HController
{
    public function filters()
    {
        return array(
            'ajaxOnly + validate, finish',
        );
    }

    public function actionIndex()
    {
        $session = Yii::app()->session;
        $service = Yii::app()->request->getQuery('service');
        if (!empty($service)) {
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
		}else{
            $regdata = Yii::app()->user->getFlash('regdata');

            if (empty($regdata))
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $this->pageTitle = 'Веселый Жираф - сайт для всей семьи';
            Yii::import('site.frontend.widgets.*');
            Yii::import('site.frontend.widgets.home.*');

            $model = new User;
            $this->registerUserData = $regdata;
            if (isset($regdata['first_name']))
                $model->first_name = $regdata['first_name'];
            if (isset($regdata['last_name']))
                $model->last_name = $regdata['last_name'];

            $this->registerUserModel = $model;

            $this->render('/site/home',array('user'=>Yii::app()->user));
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
			if($model->save(true, array('first_name', 'last_name', 'password', 'email', 'gender', 'birthday')))
			{
                if (!empty($model->birthday))
                    UserScores::checkProfileScores($model->id, ScoreAction::ACTION_PROFILE_BIRTHDAY);

                if (isset($_POST['User']['avatar'])) {
                    $url = $_POST['User']['avatar'];

                    $dir = Yii::getPathOfAlias('site.common.uploads.photos');
                    $original_dir = $dir . DIRECTORY_SEPARATOR . AlbumPhoto::model()->original_folder . DIRECTORY_SEPARATOR . $model->id;

                    if (!file_exists($original_dir))
                        mkdir($original_dir, 0755);

                    $src = $original_dir . DIRECTORY_SEPARATOR . 'avatar.jpeg';
                    file_put_contents($src, file_get_contents($url));

                    $photo = new AlbumPhoto;
                    $photo->file_name = 'avatar.jpeg';
                    $photo->fs_name = 'avatar.jpeg';
                    $photo->author_id = $model->id;
                    $photo->save();

                    $picture = new Imagick($src);

                    $a1 = clone $picture;
                    $a1->resizeimage(24, 24, imagick::COLOR_OPACITY, 1);
                    $a1->writeImage($photo->getAvatarPath('small'));

                    $a2 = clone $picture;
                    $a2->resizeimage(72, 72, imagick::COLOR_OPACITY, 1);
                    $a2->writeImage($photo->getAvatarPath('ava'));

                    $attach = new AttachPhoto;
                    $attach->entity = 'User';
                    $attach->entity_id = $model->id;
                    $attach->photo_id = $photo->id;
                    $attach->save();

                    $model->avatar_id = $photo->id;
                    $model->save();

                    UserScores::checkProfileScores($model->id, ScoreAction::ACTION_PROFILE_PHOTO);
                }

                /*Yii::app()->mc->sendToEmail($model->email, $model, 'user_registration');*/
                Yii::app()->mandrill->send($model, 'confirmEmail', array(
                    'password' => $_POST['User']['password'],
                    'code' => $model->confirmationCode,
                ));
				unset($session['service']);
                $identity = new UserIdentity($model->getAttributes());
                $identity->authenticate();
                Yii::app()->user->login($identity);
                $model->login_date = date('Y-m-d H:i:s');
                $model->last_ip = $_SERVER['REMOTE_ADDR'];
                $model->save(false);

                $redirectUrl = Yii::app()->user->getState('redirectUrl');
                if (!empty($redirectUrl)){
                    $url = $redirectUrl;
                    Yii::app()->user->setState('redirectUrl', null);
                }
                else
                    $url = Yii::app()->createAbsoluteUrl('user/profile', array('user_id'=>$model->id));

                    echo CJSON::encode(array(
                    'status' => true,
                    'profile'=>$url
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