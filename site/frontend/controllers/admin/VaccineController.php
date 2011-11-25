<?php

class VaccineController extends Controller
{
    public $layout = '//layouts/club';
    private $_model;

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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'),
                'users' => array('*'),
            ),
//            array('allow',
//                'actions' => array('index', 'view'),
//                'users' => array('*'),
//            ),
//            array('allow',
//                'actions' => array('create', 'update'),
//                'users' => array('@'),
//            ),
//            array('allow',
//                'actions' => array('admin', 'delete'),
//                'users' => array('admin'),
//            ),
//            array('deny',
//                'users' => array('*'),
//            ),
        );
    }

    public function actionView()
    {
        $this->render('view', array(
            'model' => $this->loadModel(),
        ));
    }

    public function actionCreate()
    {
        $model = new Vaccine;

        $this->performAjaxValidation($model);

        if (isset($_POST['Vaccine'])) {
            $model->attributes = $_POST['Vaccine'];


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

        if (isset($_POST['Vaccine'])) {
            $model->attributes = $_POST['Vaccine'];

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
        $dataProvider = new CActiveDataProvider('Vaccine');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin()
    {
        $model = new Vaccine('search');
        if (isset($_GET['Vaccine']))
            $model->attributes = $_GET['Vaccine'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Vaccine::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        return $this->_model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vaccine-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
