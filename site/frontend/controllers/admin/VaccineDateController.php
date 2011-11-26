<?php

class VaccineDateController extends Controller
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
        $model = new VaccineDate;
        $model->vote_agree = 0;
        $model->vote_decline = 0;
        $model->vote_did = 0;

        $this->performAjaxValidation($model);

        if (isset($_POST['VaccineDate'])) {
            $model->attributes = $_POST['VaccineDate'];
            if (isset($_POST['VaccineDate']['VaccineDisease']))
                $model->diseases = $_POST['VaccineDate']['VaccineDisease'];

            if ($model->save()) {
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate()
    {
        $model = $this->loadModel();

        $this->performAjaxValidation($model);

        if (isset($_POST['VaccineDate'])) {
            $model->attributes = $_POST['VaccineDate'];
            if (isset($_POST['VaccineDate']['VaccineDisease']))
                $model->diseases = $_POST['VaccineDate']['VaccineDisease'];

            if ($model->save())
                $this->redirect(array('admin'));
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
        $dataProvider = new CActiveDataProvider('VaccineDate');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin()
    {
        $model = new VaccineDate('search');
        if (isset($_GET['VaccineDate']))
            $model->attributes = $_GET['VaccineDate'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = VaccineDate::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        return $this->_model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vaccine-date-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
