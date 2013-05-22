<?php

class SiteController extends BController
{
    public $layout = 'shop';

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index', 'logout', 'stat'),
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
        $this->render('index');
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

            if (!Yii::app()->authManager->checkAccess('admin panel access', $userModel->id))
                throw new CHttpException(404, 'Недостаточно прав.'.$userModel->id);

            if ($userModel)
            {
                $identity=new AdminUserIdentity($userModel->getAttributes());
                $identity->authenticate();
                if ($identity->errorCode == AdminUserIdentity::ERROR_NONE)
                {
                    Yii::app()->user->login($identity);
                    $this->redirect(array('site/'));
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

    public function actionStat(){
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');
        Yii::import('site.frontend.modules.services.modules.names.models.*');

        $this->render('stat');
    }
}