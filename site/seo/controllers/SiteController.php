<?php

class SiteController extends SController
{
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index', 'logout', 'modules'),
                'users' => array('@'),
            ),
            array('allow',
                'actions'=>array('login', 'test'),
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
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];

            $userModel = new SeoUser('login');
            $userModel = $userModel->find(array(
                'condition' => 'email=:email AND password=:password',
                'params'=>array(
                    ':email'=>$model->username,
                    ':password'=>md5($model->password),
                )));

            if ($userModel !== null){
                $identity=new SeoUserIdentity($userModel->getAttributes());
                $identity->authenticate();
                if ($identity->errorCode == SeoUserIdentity::ERROR_NONE)
                {
                    Yii::app()->user->login($identity);
                    $this->redirect(array('site/index'));
                }
            }
            else
                $model->addError('username', 'Неправильный логин или пароль');
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionModules(){
        $this->render('modules');
    }
}