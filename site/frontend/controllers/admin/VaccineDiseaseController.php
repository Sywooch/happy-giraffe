<?php
Yii::import('site.frontend.modules.recipeBook.models.*');
class VaccineDiseaseController extends Controller
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
        $model = new VaccineDisease;

        $this->performAjaxValidation($model);

        if (isset($_POST['VaccineDisease'])) {
            $model->attributes = $_POST['VaccineDisease'];


            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate()
    {
        $model = $this->loadModel();

        $this->performAjaxValidation($model);

        if (isset($_POST['VaccineDisease'])) {
            $model->attributes = $_POST['VaccineDisease'];

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
        $dataProvider = new CActiveDataProvider('VaccineDisease');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin()
    {
        $model = new VaccineDisease('search');
        if (isset($_GET['VaccineDisease']))
            $model->attributes = $_GET['VaccineDisease'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = VaccineDisease::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        return $this->_model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vaccine-disease-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
