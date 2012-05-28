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
        if (Yii::app()->user->checkAccess('moderator'))
            $this->redirect($this->createUrl('task/moderator'));

        if (Yii::app()->user->checkAccess('admin'))
            $this->redirect($this->createUrl('user/'));

        if (Yii::app()->user->checkAccess('author'))
            $this->redirect($this->createUrl('task/author'));

        if (Yii::app()->user->checkAccess('editor'))
            $this->redirect($this->createUrl('editor/reports'));

        if (Yii::app()->user->checkAccess('content-manager'))
            $this->redirect($this->createUrl('task/ContentManager'));

        if (Yii::app()->user->checkAccess('articles-input'))
            $this->redirect($this->createUrl('existArticles/index'));

        if (Yii::app()->user->checkAccess('corrector'))
            $this->redirect($this->createUrl('task/corrector'));
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

    /*public function actionTest()
    {
        $k = 1;
        for($i=0;$i<2000;$i++){
            $keyword = $this->nextKeyword();
            if ($keyword !== null){
                $keywords = Keywords::model()->findAllByAttributes(array('name'=>$keyword->name));
                    foreach($keywords as $keyword2)
                        if ($keyword2->id > $keyword->id){
                            $keyword2->delete();
                            echo $k.'. '.$keyword->name.'<br>';
                            $k++;
                        }
            }
            if ($i % 1000 == 0){
                echo $i.'<br>';
            }
            flush();
        }
    }

    private $i = 130;
    private $j = 0;
    private $keywords = array();
    private $limit = 100;

    public function nextKeyword()
    {
        if ($this->j >= $this->limit || empty($this->keywords)) {
            $this->keywords = $this->getKeywords();
            $this->j = 0;
        }

        $result = $this->keywords[$this->j];
        $this->j++;

        return $result;
    }

    public function getKeywords()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = $this->limit;
        $criteria->offset = $this->limit * $this->i;
        $criteria->order = 'id';
        $this->i++;

        return Keywords::model()->findAll($criteria);
    }*/
}