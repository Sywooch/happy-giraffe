<?php

class SiteController extends HController
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

    public function actionServices($category_id = null)
    {
        $categories = ServiceCategory::model()->with('servicesCount')->findAll();

        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $category_id);

        $services = ServiceCategory::model()->with('services')->findAll($criteria);

        $this->pageTitle = 'Полезные сервисы для всей семьи';
        $this->render('services', compact('categories', 'services', 'category_id'));
    }

    public function actionSeoHide($hash)
    {
        header('Content-type: text/javascript');
        $cacheId = 'seoHide_' . $hash;
        $value = Yii::app()->cache->get($cacheId);
        if ($value !== false) {
            echo $value;
        }
    }

    public function actionSearch($text = false, $index = false)
    {
        $this->meta_title = 'Поиск по сайту Веселый Жираф';
        if (!empty($text)){
        $index = $index ? $index : 'community';
        $pages = new CPagination();
        $pages->pageSize = 100000;
        $criteria = new stdClass();
        $criteria->from = $index;
        $criteria->select = '*';
        $criteria->paginator = $pages;
        $criteria->query = $text;
        $resIterator = Yii::app()->search->search($criteria);

        $allSearch = $textSearch = Yii::app()->search->select('*')->from('community')->where($criteria->query)->limit(0, 100000)->searchRaw();
        $allCount = count($allSearch['matches']);

        $textSearch = Yii::app()->search->select('*')->from('communityText')->where($criteria->query)->limit(0, 100000)->searchRaw();
        $textCount = count($textSearch['matches']);

        $videoSearch = Yii::app()->search->select('*')->from('communityVideo')->where($criteria->query)->limit(0, 100000)->searchRaw();
        $videoCount = count($videoSearch['matches']);

        $criteria = new CDbCriteria;
        $criteria->with = array('travel', 'video', 'post');

        $dataProvider = new CArrayDataProvider($resIterator->getRawData(), array(
            'keyField' => 'id',
        ));

            $viewData = compact('dataProvider', 'criteria', 'index', 'text', 'allCount', 'textCount', 'videoCount', 'travelCount');
        }else
            $viewData = array('dataProvider'=>null, 'criteria'=>null, 'index'=>$index, 'text'=>'', 'allCount'=>0, 'textCount'=>0, 'videoCount'=>0, 'travelCount'=>0);
        $this->render('search', $viewData);
    }

	/**
	 * @sitemap changefreq=daily
	 */
	public function actionIndex()
	{
		$this->pageTitle = 'Веселый Жираф - сайт для всей семьи';
        Yii::import('site.frontend.widgets.*');
        Yii::import('site.frontend.widgets.home.*');
        $user = Yii::app()->user->getModel();
        $this->render('home', compact('user'));
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
            {
                if(file_exists(Yii::getPathOfAlias('application.views.system.' . $error['code']) . '.php'))
                {
                    $this->layout = '//system/layout';
                    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/stylesheets/common.css');
                    $this->render('//system/' . $error['code'], $error);
                }
                else
                    $this->render('error', $error);
            }
	    }
	}

    public function actionMaintenance()
    {
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        $this->layout = '//system/layout';
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/stylesheets/maintenance.css');
        $this->render('//system/maintenance');
    }

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionLogin()
	{
		$service = Yii::app()->request->getQuery('service');
        $settings = Yii::app()->request->getQuery('settings');
		if (isset($service)) {
            if (! in_array($service, array_keys(Yii::app()->eauth->services)))
                throw new CHttpException(404, 'Страница не найдена');

			$authIdentity = Yii::app()->eauth->getIdentity($service);
            $redirectUrl = Yii::app()->user->loginUrl;
            if(isset($_SERVER['HTTP_REFERER']) && $url_info = parse_url($_SERVER['HTTP_REFERER']))
            {
                if($url_info['host'] == $_SERVER['HTTP_HOST'])
                {
                    $redirectUrl = $url_info['path'];
                    if ($settings !== null && strpos($redirectUrl, 'openSettings') === false) {
                        if (isset($url_info['query'])) {
                            $redirectUrl .= '&openSettings=1';
                        }
                        else {
                            $redirectUrl .= '?openSettings=1';
                        }
                    }
                    if (strpos($_SERVER['HTTP_REFERER'], 'site/login') === false)
                        Yii::app()->user->setState('social_redirect', $redirectUrl);
                }
            }
            $authIdentity->redirectUrl = $redirectUrl;
			if ($authIdentity->authenticate()) {
				$name = $authIdentity->getServiceName();
				$id = $authIdentity->getAttribute('id');
				$check = UserSocialService::model()->findByAttributes(array(
					'service' => $name,
					'service_id' => $id,
				));
				if ($check !== null)
				{
					$user = User::model()->active()->findByPk($check->user_id);
                    if ($user === null)
                        throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

					$identity = new UserIdentity($user->getAttributes());
					$identity->authenticate();
					if ($identity->errorCode == UserIdentity::ERROR_NONE)
					{
						Yii::app()->user->login($identity);
                        $user->login_date = date('Y-m-d H:i:s');
                        $user->save(false);
                        $rediret_url = Yii::app()->user->getState('social_redirect');
                        if(Yii::app()->request->getQuery('register'))
                            $authIdentity->redirect('/');
						$authIdentity->redirect($rediret_url);
					}
				}
                elseif(!Yii::app()->user->isGuest)
                {
                    $social_service = new UserSocialService;
                    $social_service->user_id = Yii::app()->user->id;
                    $social_service->service = $name;
                    $social_service->service_id = $id;
                    $social_service->name = implode(' ', array($authIdentity->getAttribute('first_name'), $authIdentity->getAttribute('last_name')));
                    if ($name == 'mailru')
                        $social_service->url = $authIdentity->getAttribute('link');
                    $social_service->save();
                }
                else
                {
                    $session = Yii::app()->session;
                    $session['service'] = array(
                        'name' => $authIdentity->getServiceName(),
                        'id' => $authIdentity->getAttribute('id'),
                    );

                    $reg_data = $authIdentity->getItemAttributes();
                    $type = 'default';
                    $this->render('/signup/social_register', compact('reg_data', 'type'));
                }
			}

			$authIdentity->redirect('');
		}

		$userModel = new User('login');

		$this->performAjaxValidation($userModel);

		if (isset($_POST['User']))
		{
            $userModel->attributes = $_POST['User'];
			if($userModel->validate())
                $this->redirect(Yii::app()->request->urlReferrer);
		}
	}

    public function actionLogout()
    {
        Yii::app()->user->logout(false);
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionRememberPassword($step)
    {
        /*if(!Yii::app()->request->isPostRequest || !Yii::app()->request->getPost('email'))
            Yii::app()->end();*/
        $email = Yii::app()->request->getPost('email');
        $error = false;
        $code = null;
        if(Yii::app()->request->getPost('code') !== null)
            $code = Yii::app()->request->getPost('code');
        if($step == 2)
        {
            $user = User::model()->active()->findByAttributes(array('email' => $email));
            if(!$user)
            {
                $step = 1;
                $error = 'Пользователь не найден.';
            }
            else
            {
                if($code === null || $code === 'null')
                {
                    $user->remember_code = rand(10000, 99999);
                    $user->save();
                    Yii::app()->mc->sendToEmail($user->email, $user, 'remember_password');
                }
                else
                {
                    $user = User::model()->active()->findByAttributes(array('email' => $email, 'remember_code' => $code));
                    if(!$user)
                    {
                        $error = 'Неверный код подтверждения';
                    }
                    else
                    {
                        $step = 3;
                    }
                }
            }
        }
        if($step == 3)
        {
            $user = User::model()->active()->findByAttributes(array('email' => $email, 'remember_code' => $code));
            if(!$user)
            {
                $step = 1;
                $error = 'Пользователь не найден.';
            }
            else
            {
                $password = Yii::app()->request->getPost('password') !== null ? Yii::app()->request->getPost('password') : null;
                if($password !== null && $password !== 'null')
                {
                    $user->scenario = 'remember_password';
                    $user->password = $password;
                    if(!$user->save(array('password')))
                    {
                        $error = $user->errors['password'][0];
                    }
                    else
                    {
                        $user->scenario = 'update';
                        $identity = new UserIdentity($user->getAttributes());
                        $identity->authenticate();
                        Yii::app()->user->login($identity);
                        $user->login_date = date('Y-m-d H:i:s');
                        $user->last_ip = $_SERVER['REMOTE_ADDR'];
                        $user->remember_code = '';
                        $user->save(false);

                        $step = 4;
                    }
                }
            }
        }
        $this->renderPartial('remember_password/step' . $step, array('step' => $step, 'email' => $email, 'code' => $code,'error' => $error));
    }

    public function actionContest()
    {
         $this->render('contest');
    }

    public function actionConfirmEmail($user_id, $code)
    {
        $user = User::model()->findByPk($user_id);
        if ($user === null || $user->email_confirmed || $code != $user->confirmationCode)
            throw new CHttpException(404);

        $user->email_confirmed = 1;
        if ($user->update(array('email_confirmed')))
            UserScores::checkProfileScores($user->id, ScoreAction::ACTION_PROFILE_EMAIL);

        $identity = new SafeUserIdentity($user_id);
        if ($identity->authenticate())
            Yii::app()->user->login($identity);
        $this->redirect($user->url);
    }

    public function actionResendConfirmEmail()
    {
        $user = Yii::app()->user->model;
        if ($user === null || $user->email_confirmed)
            throw new CHttpException(404);

        echo Yii::app()->mandrill->send($user, 'resendConfirmEmail', array(
            'code' => $user->confirmationCode,
        ));
    }

    public function actionPasswordRecoveryForm()
    {
        $this->renderPartial('passwordRecoveryForm');
    }

    public function actionPasswordRecovery()
    {
        $email = Yii::app()->request->getPost('email');
        if (empty($email)) {
            echo CJSON::encode(array(
                'status' => 'error',
                'message' => '<span>Введите e-mail.</span>'
            ));
            Yii::app()->end();
        }

        $user = User::model()->findByAttributes(array('email' => $email));
        if ($user === null) {
            echo CJSON::encode(array(
                'status' => 'error',
                'message' => '<span>Пользователя с таким e-mail не существует.</span>',
            ));
            Yii::app()->end();
        }
        if ($user->recovery_disable)
            Yii::app()->end();

        $password = $user->createPassword(12);
        $user->password = $user->hashPassword($password);

        if (! ($user->save() &&  Yii::app()->mandrill->send($user, 'passwordRecovery', array('password' => $password)))) {
            echo CJSON::encode(array(
                'status' => 'error',
                'message' => '<span>Произошла неизвестная ошибка. Попробуйте ещё раз.</span>',
            ));
        } else {
            echo CJSON::encode(array(
                'status' => 'ok',
                'message' => '<span>На ваш e-mail адрес было выслано письмо с вашим паролем</span><br/><span>(также проверьте, пожалуйста, папку «Спам»)</span>',
            ));
        }
    }

    public function actionFixPhoto($id)
    {
        $photo = AlbumPhoto::model()->findByPk($id);
        $photo->getPreviewPath(210, null, Image::WIDTH, false, AlbumPhoto::CROP_SIDE_CENTER, true);
    }

    public function actionModerationRules(){
        $this->layout = 'common';
        $this->render('moder_rules');
    }
}