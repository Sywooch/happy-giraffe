<?php

class SiteController extends HController
{
    public $layout = '//layouts/main';
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

    protected function beforeAction($action)
    {
        return $action->id == 'error' ? true : parent::beforeAction($action);
    }

    protected function afterRender($view, &$output)
    {
        if ($this->action->id != 'error')
            parent::afterRender($view, $output);
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
        $criteria->query = Str::prepareForSphinxSearch($text);
        $resIterator = Yii::app()->search->search($criteria);

        $allSearch = $textSearch = Yii::app()->search->select('*')->from('community')->where($criteria->query)->limit(0, 100000)->searchRaw();
        $allCount = count($allSearch['matches']);

        $textSearch = Yii::app()->search->select('*')->from('communityText')->where($criteria->query)->limit(0, 100000)->searchRaw();
        $textCount = count($textSearch['matches']);

        $videoSearch = Yii::app()->search->select('*')->from('communityVideo')->where($criteria->query)->limit(0, 100000)->searchRaw();
        $videoCount = count($videoSearch['matches']);

        $criteria = new CDbCriteria;
        $criteria->with = array('video', 'post');

        $dataProvider = new CArrayDataProvider($resIterator->getRawData(), array(
            'keyField' => 'id',
        ));

            $viewData = compact('dataProvider', 'criteria', 'index', 'text', 'allCount', 'textCount', 'videoCount');
        }else
            $viewData = array('dataProvider'=>null, 'criteria'=>null, 'index'=>$index, 'text'=>'', 'allCount'=>0, 'textCount'=>0, 'videoCount'=>0);
        $this->render('search', $viewData);
    }

	/**
	 * @sitemap changefreq=daily
	 */
	public function actionIndex($openLogin = false)
	{
        if ($openLogin !== false)
            Yii::app()->clientScript->registerLinkTag('canonical', null, $this->createAbsoluteUrl(''));

        if (! Yii::app()->user->isGuest)
            $this->redirect(array('myGiraffe/default/index', 'type' => 1));

        $this->layout = '//layouts/common';
		$this->pageTitle = 'Веселый Жираф - сайт для всей семьи';
        $this->render('home', compact('openLogin'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if ($error = Yii::app()->errorHandler->error)
	    {
	    	if (Yii::app()->request->isAjaxRequest)
                echo $error->message;
	    	else
            {
                $viewFile = Yii::app()->getSystemViewPath() . DIRECTORY_SEPARATOR . 'error' . $error['code'] . '.php';
                if (is_file($viewFile))
                    $this->renderPartial('//system/' . 'error' . $error['code'], $error);
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
            if (isset($_GET['redirect_to']))
                Yii::app()->user->setState('redirect_to', $_GET['redirect_to']);

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
			if($userModel->validate()){
                //check redirect
                if (isset($_POST['redirect_to']))
                    Yii::app()->user->setState('redirect_to', $_POST['redirect_to']);

                $this->redirect(Yii::app()->request->urlReferrer);
            }
		}
	}

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('site/index'));
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
        if ($user === null || $code != $user->confirmationCode)
            throw new CHttpException(404);

        if (!$user->email_confirmed){
            $user->email_confirmed = 1;
            $user->update(array('email_confirmed'));
        }

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

        echo Yii::app()->email->send($user, 'resendConfirmEmail', array(
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

        $success = $user->save() &&  Yii::app()->email->send($user, 'passwordRecovery', array('password' => $password));
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionFixPhoto($id)
    {
        $photo = AlbumPhoto::model()->findByPk($id);
        $photo->getPreviewPath(210, null, Image::WIDTH, false, AlbumPhoto::CROP_SIDE_CENTER, true);
    }

    public function actionModerationRules(){
        $this->layout = 'common';
        $this->pageTitle = 'Правила модерации на Веселом Жирафе';

        $this->render('moder_rules');
    }

    public function actionTest()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $url = 'http://habrahabr.ru/post/183598/';
        $res = LinkParser::getInstance()->parse($url);

        var_dump($res);
    }

    public function actionOut($url)
    {
        $this->redirect($url);
    }

    public function actionHh($code)
    {
        $hh = new HhParser($code);
        $data = $hh->run();

        $fp = fopen(Yii::getPathOfAlias('site.common.data') . '/hh.csv', 'w');

        foreach ($data as $fields)
            fputcsv($fp, $fields);

        fclose($fp);
    }

    public function actionFlushSchema()
    {
        // Load all tables of the application in the schema
        Yii::app()->db->schema->getTables();
        // clear the cache of all loaded tables
        Yii::app()->db->schema->refresh();

        Yii::app()->db->schema->getTable('myTable',true);
    }

    public function actionVacancy()
    {
        $model = new VacancyForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vacancyForm')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['VacancyForm'])) {
            $model->attributes = $_POST['VacancyForm'];
            $success = $model->validate();
            if ($success)
                $model->send();
            echo CJSON::encode(compact('success'));
        } else {
            $this->layout = '//layouts/common';
            $this->pageTitle = 'Вакансия «Web-разработчик»';
            $this->render('vacancy', compact('model'));
        }
    }

    public function actionVacancySend()
    {
        $emails = array('nikita@happy-giraffe.ru', 'info@happy-giraffe.ru', 'mira.smurkov@gmail.com');
        foreach ($emails as $e) {
            $html = $this->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . 'vacancy.php', $_POST, true);
            ElasticEmail::send($e, 'Отклик на вакансию', $html, 'noreply@happy-giraffe.ru', 'Веселый Жираф');
        }
    }

    public function actionQualityTest($url = null)
    {
        $qArray = range(60, 90, 5);
        foreach ($qArray as $q) {
            $phpThumb = Yii::createComponent(array(
                'class' => 'ext.EPhpThumb.EPhpThumb',
                'options' => array(
                    'jpegQuality' => $q,
                ),
            ));
            $phpThumb->init();
            $path = Yii::getPathOfAlias('site.common.uploads.photos.temp') . DIRECTORY_SEPARATOR . md5($url . $q) . '.jpg';
            $thumb = $phpThumb->create($url);
            $thumb->save($path);
            echo $q . ':<br>' . CHtml::image(Yii::app()->params['photos_url'] . '/temp/' . md5($url . $q) . '.jpg') . '<br><br><br>';
        }
    }

    public function actionSeo()
    {
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        if ($_POST) {
            foreach ($_POST as $k => $val)
                Yii::app()->user->setState($k, $val);
        }

        if ($_POST || Yii::app()->request->isAjaxRequest) {
            $result = array();
            Yii::import('site.frontend.extensions.GoogleAnalytics');

            $ga = new GoogleAnalytics('nikita@happy-giraffe.ru', 'ummvxhwmqzkrpgzj');
            $ga->setProfile('ga:53688414');

            $ga->setDateRange(Yii::app()->user->getState('period1Start'), Yii::app()->user->getState('period1End'));
            $pathes1 = $ga->getReport(array(
                'metrics' => 'ga:visits',
                'dimensions' => 'ga:pagePath',
                'max-results' => 10000,
                'sort' => '-ga:visits',
                'filters' => 'ga:source==google',
            ));
            foreach ($pathes1 as $path => $value) {
                $result[$path] = array(
                    'period1' => $value['ga:visits'],
                    'period2' => 0,
                    'diff' => 0,
                    'diffC' => 0,
                );
            }

            $ga->setDateRange(Yii::app()->user->getState('period2Start'), Yii::app()->user->getState('period2End'));
            $pathes2 = $ga->getReport(array(
                'metrics' => 'ga:visits',
                'dimensions' => 'ga:pagePath',
                'max-results' => 10000,
                'sort' => '-ga:visits',
                'filters' => 'ga:source==yandex',
            ));
            foreach ($pathes2 as $path => $value) {
                if (isset($result[$path])) {
                    $result[$path]['period2'] = $value['ga:visits'];
                    $result[$path]['diff'] = ($result[$path]['period2'] - $result[$path]['period1']) * 100 / $result[$path]['period1'];
                    $result[$path]['diffC'] = $result[$path]['period2'] - $result[$path]['period1'];
                } else {
                    $result[$path] = array(
                        'period1' => 0,
                        'period2' => $value['ga:visits'],
                        'diff' => 0,
                        'diffC' => 0,
                    );
                }
            }

            $_result = array();
            foreach ($result as $k => $r) {
                $r['id'] = $k;
                if ($r['diff'] < 0)
                    array_push($_result, $r);
            }

            $s = 0;
            foreach ($_result as $v)
                $s += $v['diffC'];

            $dp = new CArrayDataProvider($_result, array(
                'sort' => array(
                    'attributes' => array('id', 'period1', 'period2', 'diffC', 'diff'),
                    'defaultOrder' => array('period1'=>true),
                ),
                'pagination' => array(
                    'pageSize' => 200,
                ),
            ));
        }
        else
            $dp = null;
        $this->render('seo', compact('dp', 's'));
    }

    public function actionSeo2()
    {
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $dp = new EMongoDocumentDataProvider('Seo2', array(
            'sort' => array(
                'attributes' => array('google', 'yandex'),
            ),
            'pagination' => array(
                'pageSize' => 200,
            ),
        ));
        $this->render('seo2', compact('dp'));
    }

    public function actionSeo3()
    {
        $ageRange = AgeRange::model()->find();
        var_dump($ageRange->test2);
        die;

        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $dp = new EMongoDocumentDataProvider('Seo3', array(
            'sort' => array(
                'attributes' => array('google', 'yandex'),
            ),
            'pagination' => array(
                'pageSize' => 200,
            ),
        ));
        $this->render('seo2', compact('dp'));
    }
}