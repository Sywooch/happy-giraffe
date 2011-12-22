<?php

class NameController extends AController
{
    public $layout = '//layouts/club';

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'),
                'users' => array('*'),
            ));
    }

    private $_model;

    public function actionView()
    {
        $this->render('view', array(
            'model' => $this->loadModel(),
        ));
    }

    public function actionCreate()
    {
        $model = new Name;

        $this->performAjaxValidation($model);

        if (isset($_POST['Name'])) {
            $model->attributes = $_POST['Name'];
            if (isset($_POST['Name']['User']))
                $model->users = $_POST['Name']['User'];


            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate()
    {
        $model = $this->loadModel();

        $this->performAjaxValidation($model);

        if (isset($_POST['Name'])) {
            $model->attributes = $_POST['Name'];
            if (isset($_POST['Name']['User']))
                $model->users = $_POST['Name']['User'];

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel()->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,
                Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Name');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin()
    {
        $model = new Name('search');
        if (isset($_GET['Name']))
            $model->attributes = $_GET['Name'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Name::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        return $this->_model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'name-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
