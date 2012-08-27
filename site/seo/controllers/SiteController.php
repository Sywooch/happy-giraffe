<?php

class SiteController extends SController
{
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'logout', 'modules'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('login', 'test', 'sql'),
                'users' => array('*'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        if (count($this->getUserModules()) > 1)
            $this->redirect($this->createUrl('site/modules'));

        if (Yii::app()->user->checkAccess('moderator'))
            $this->redirect($this->createUrl('writing/task/moderator'));

        if (Yii::app()->user->checkAccess('admin'))
            $this->redirect($this->createUrl('user/'));

        if (Yii::app()->user->checkAccess('author'))
            $this->redirect($this->createUrl('writing/task/author'));

        if (Yii::app()->user->checkAccess('editor'))
            $this->redirect($this->createUrl('competitors/default/index'));

        if (Yii::app()->user->checkAccess('content-manager'))
            $this->redirect($this->createUrl('writing/task/ContentManager'));

        if (Yii::app()->user->checkAccess('articles-input'))
            $this->redirect($this->createUrl('writing/existArticles/index'));

        if (Yii::app()->user->checkAccess('corrector'))
            $this->redirect($this->createUrl('writing/task/corrector'));

        if (Yii::app()->user->checkAccess('superuser'))
            $this->redirect($this->createUrl('competitors/default/index'));

        if (Yii::app()->user->checkAccess('promotion'))
            $this->redirect($this->createUrl('promotion/queries/admin'));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $this->layout = 'none';
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];

            $userModel = new SeoUser('login');
            $userModel = $userModel->find(array(
                'condition' => 'email=:email AND password=:password',
                'params' => array(
                    ':email' => $model->username,
                    ':password' => md5($model->password),
                )));

            if ($userModel !== null) {
                $identity = new SeoUserIdentity($userModel->getAttributes());
                $identity->authenticate();
                if ($identity->errorCode == SeoUserIdentity::ERROR_NONE) {
                    Yii::app()->user->login($identity);
                    $this->redirect(array('site/index'));
                }
            } else
                $model->addError('username', 'Неправильный логин или пароль');
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionModules()
    {
        $this->render('modules');
    }

    public function actionTest()
    {
        $proxy = '82.192.85.54:60504';

        $ch = curl_init('http://wordstat.yandex.ru/?cmd=words&page=1&t=%D0%BC%D0%B0%D0%BC%D0%B0+%2B%D0%B8+%D1%81%D1%8B%D0%BD&geo=&text_geo=');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.1; WOW64; U; ru) Presto/2.10.289 Version/12.00');

        //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
//            if (getenv('SERVER_ADDR') != '5.9.7.81') {
//                curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia12345");
//                curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
//            }

        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $content = curl_exec($ch);

        if ($content === false) {
            if (curl_errno($ch)) {
                echo curl_errno($ch).'-'.curl_error($ch);
            }
        }
        curl_close($ch);

        //Errors
        // 7-couldn't connect to host
        // 7-Failed to receive SOCKS5 connect request ack.
        // <title>Статистика ключевых слов на Яндексе
    }

    public function actionSql($sql = '')
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $long_time = 0;
        if (!empty($sql)){
            $start_time = microtime(true);
            Yii::app()->db_seo->createCommand($sql)->execute();
            $long_time = 1000*(microtime(true) - $start_time);
        }

        $this->render('sql', compact('sql', 'long_time'));
    }
}