<?php

class SiteController extends SController
{
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index', 'logout'),
                'users' => array('@'),
            ),
            array('allow',
                'actions'=>array('login'),
                'users' => array('*'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

	public function actionIndex()
	{
        if (Yii::app()->user->checkAccess('moderator'))
            $this->redirect($this->createUrl('task/moderator'));
        if (Yii::app()->user->checkAccess('author'))
            $this->redirect($this->createUrl('task/author'));
        if (Yii::app()->user->checkAccess('editor'))
            $this->redirect($this->createUrl('task/tasks'));
        if (Yii::app()->user->checkAccess('content-manager'))
            $this->redirect($this->createUrl('task/cmanager'));
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

            $userModel = new User('login');
            $userModel = $userModel->find(array(
                'condition' => 'email=:email AND password=:password',
                'params'=>array(
                    ':email'=>$model->username,
                    ':password'=>md5($model->password),
                )));

            if ($userModel === null){
                $this->render('login',array('model'=>$model));
                Yii::app()->end();
            }

            if ($userModel)
            {
                $identity=new SeoUserIdentity($userModel->getAttributes());
                $identity->authenticate();
                if ($identity->errorCode == SeoUserIdentity::ERROR_NONE)
                {
                    Yii::app()->user->login($identity);
                    $this->redirect(array('site/index'));
                }
            }
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
}