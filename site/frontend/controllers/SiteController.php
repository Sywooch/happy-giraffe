<?php

class SiteController extends LiteController
{
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
                'actions'=>array('stats'),
                'roles'=>array('moderator'),
            ),
            array('deny',
                'actions'=>array('stats'),
                'users'=>array('*'),
            ),
        );
    }

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

	/**
	 * @sitemap changefreq=daily
	 */
	public function actionIndex($openLogin = false, $openRegister = false)
	{
        Yii::app()->clientScript->useAMD = true;

        if ($openLogin !== false)
            Yii::app()->clientScript->registerLinkTag('canonical', null, $this->createAbsoluteUrl(''));

        if (! Yii::app()->user->isGuest)
            $this->redirect(array('/som/activity/onAir/index'));

        $this->layout = false;
        $this->render('home', compact('openLogin', 'openRegister'));
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

    public function actionModerationRules(){
        $this->layout = 'common';
        $this->pageTitle = 'Правила модерации на Веселом Жирафе';

        $this->render('moder_rules');
    }

    public function actionOut($url)
    {
        $this->redirect($url);
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

    public function actionStats($nocache = false)
    {
        $ds = new DailyStats($nocache);
        $data = $ds->getData();

        $dp = new CArrayDataProvider($data, array(
            'sort' => array(
                'attributes' => array('id', 'comments', 'users', 'posts'),
                'defaultOrder' => array('id' => true),
            ),
        ));

        $contests = \site\frontend\modules\comments\modules\contest\models\CommentatorsContest::model()->findAll();

        $this->render('stats', compact('dp', 'contests'));
    }

    public function actionSend()
    {
        header('Access-Control-Allow-Origin: http://seo.happy-giraffe.ru');

        if (Yii::app()->request->urlReferrer !== 'http://seo.happy-giraffe.ru/best/email/') {
            Yii::app()->end();
        }

        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.frontend.modules.messaging.models.*');
        Yii::import('site.frontend.modules.messaging.components.*');
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.widgets.userAvatarWidget.Avatar');
        Yii::import('site.common.models.mongo.*');

        $subject = Yii::app()->request->getPost('subject', null);
        $real = Yii::app()->request->getPost('real', false);

        $lastSend = Yii::app()->getGlobalState('lastSend', 0);
        if (($lastSend > (time() - 3600 * 18)) && $real) {
            echo CJSON::encode(array('success' => false, 'error' => 'Сегодня уже отправляли'));
            Yii::app()->end();
        }

        if (empty($subject)) {
            echo CJSON::encode(array('success' => false, 'error' => 'Тема письма не может быть пустой'));
            Yii::app()->end();
        }

        $date = date('Y-m-d');
        $articles = Favourites::model()->getWeekPosts($date);
        if (count($articles) != 6) {
            echo CJSON::encode(array('success' => false, 'error' => 'Отмечено менее 6 постов'));
            Yii::app()->end();
        }
        $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.weeklyNews') . '.php', array('models' => $articles), true);
        if ($real) {
            ElasticEmail::sendCampaign($contents, null, 'clicked', 'weekly_news', $subject);
        } else {
            ElasticEmail::sendCampaign($contents, HEmailSender::LIST_TEST_LIST, null, 'weekly_news', $subject);
        }

        echo CJSON::encode(array('success' => true));
        if ($real) {
            Yii::app()->setGlobalState('lastSend', time());
        }
    }
}