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

    public function actionSearch($text = false, $index = false)
    {
        $index = $index ? $index : 'community';
        $pages = new CPagination();
        $pages->pageSize = 100000;
        $criteria = new stdClass();
        $criteria->from = $index;
        $criteria->select = '*';
        $criteria->paginator = $pages;
        $criteria->query = '*' . $text . '*';
        $resIterator = Yii::app()->search->search($criteria);

        $allSearch = $textSearch = Yii::app()->search->select('*')->from('community')->where('*' . $text . '*')->limit(0, 100000)->searchRaw();
        $allCount = count($allSearch['matches']);

        $textSearch = Yii::app()->search->select('*')->from('communityText')->where('*' . $text . '*')->limit(0, 100000)->searchRaw();
        $textCount = count($textSearch['matches']);

        $videoSearch = Yii::app()->search->select('*')->from('communityVideo')->where('*' . $text . '*')->limit(0, 100000)->searchRaw();
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
        if(!Yii::app()->user->isGuest)
            $this->redirect(array('/user/profile', 'user_id' => Yii::app()->user->id));
        $this->layout = '//site/index_layout';
		$this->pageTitle = 'Веселый Жираф - сайт для всей семьи';
		Yii::app()->clientScript->registerMetaTag('NWGWm2TqrA1HkWzR8YBwRT08wX-3SRzeQIBLi1PMK9M', 'google-site-verification');
		Yii::app()->clientScript->registerMetaTag('41ad6fe875ade857', 'yandex-verification');
        $model = new User;
		$this->render('index', array(
            'model' => $model
        ));
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
                if(file_exists(Yii::getPathOfAlias('application.www.themes.happy_giraffe.views.system.' . $error['code']) . '.php'))
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

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$service = Yii::app()->request->getQuery('service');
		if (isset($service)) {
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
                            $authIdentity->redirect('/site/index');
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
                    $authIdentity->redirect(array('/signup'));
                }
			}

			$authIdentity->redirect();
		}

		$userModel = new User('login');

		$this->performAjaxValidation($userModel);

		if (isset($_POST['User']))
		{
			$userModel = $userModel->find(array(
				'condition' => 'email=:email AND password=:password and blocked = 0 and deleted = 0',
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
                    $duration = $_POST['User']['remember'] == 1 ? 2592000 : 0;
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
		Yii::app()->user->logout(false);
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

			$authIdentity->redirect();
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