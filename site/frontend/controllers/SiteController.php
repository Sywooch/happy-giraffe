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

        $this->render('search', $viewData);
    }

	/**
	 * @sitemap
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
				if ($check)
				{
					$user = User::model()->active()->findByPk($check->user_id);
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
                    $social_service->save();
                }
                else
                {
                    $session = Yii::app()->session;
                    $session['service'] = array(
                        'name' => $authIdentity->getServiceName(),
                        'id' => $authIdentity->getAttribute('id'),
                    );
                    Yii::app()->user->setFlash('regdata', $authIdentity->getItemAttributes());
                    $authIdentity->redirect(array('/signup/index'));
                }
			}

			$authIdentity->redirect();
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

    public function actionLink($text)
    {
        $this->renderPartial('link', compact('text'));
    }

    public function actionTest()
    {
        $data = array(
            'u' => 'mirasmurkov',
            'k' => 'e4mownmg6njsrhrg',
            'o' => 'csearch',
            'e' => 'UTF-8',
            't' => 'хуй пизда джигурда хуй пизда джигурда хуй пизда джигурдахуй пизда джигурда хуй пизда джигурда хуй пизда джигурда',
            'c' => '1',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.copyscape.com/api/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);

        $xml = new SimpleXMLElement($res);
        var_dump(isset($xml->result[0]->percentmatched));

        die;

        $url = 'http://www.copyscape.com/api/?' . http_build_query(array(
            'u' => 'mirasmurkov',
            'k' => 'e4mownmg6njsrhrg',
            'o' => 'csearch',
            'q' => 'http://www.happy-giraffe.ru/community/20/forum/post/23151/',
            'c' => '1',
        ));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);

        $xml = new SimpleXMLElement($res);
        var_dump(isset($xml->result[0]->fsdfs));
        die;
        echo $xml->result[0]->fsdfs;
    }

    public function actionUsers()
    {
        $users = User::model()->findAll(array('condition' => 'register_date between "2012-07-01 00:00:00" AND "2012-07-16 00:00:00"'));
        foreach ($users as $u) {
            echo '<p>' . CHtml::link($this->createAbsoluteUrl('user/profile', array('user_id' => $u->id)), $this->createAbsoluteUrl('user/profile', array('user_id' => $u->id))) . '</p>';
        }
    }


    public function actionPasswordRecovery()
    {
        $email = Yii::app()->request->getPost('email');
        if (empty($email)) {
            echo false;
            Yii::app()->end();
        }

        $user = User::model()->findByAttributes(array('email' => $email));
        if ($user === null) {
            echo false;
            Yii::app()->end();
        }

        $password = $user->createPassword(12);
        $user->password = $user->hashPassword($password);
        if (! $user->save()) {
            echo false;
            Yii::app()->end();
        }

        echo Yii::app()->mandrill->send($user, 'passwordRecovery', array('password' => $password));
    }

    public function actionTest2(){
//        $vals = Yii::app()->mc->sendToGroup('самое свежее на этой неделе', MailGenerator::getWeeklyArticles());
//        var_dump($vals);
        ob_start();
        $this->beginWidget('site.common.widgets.mail.WeeklyArticlesWidget');
        $this->endWidget();

        $contents = ob_get_clean();

        $vals = Yii::app()->mc->sendWeeklyNews('самое свежее на этой неделе', $contents);

        if (Yii::app()->mc->api->errorCode){
            echo "Batch Subscribe failed!\n";
            echo "code:".Yii::app()->mc->api->errorCode."\n";
            echo "msg :".Yii::app()->mc->api->errorMessage."\n";
        } else {
            echo "added:   ".$vals['add_count']."\n";
            echo "updated: ".$vals['update_count']."\n";
            echo "errors:  ".$vals['error_count']."\n";
        }
    }
}