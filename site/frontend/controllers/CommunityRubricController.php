<?php

class CommunityRubricController extends Controller
{
    public $layout = '//layouts/column2';
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
                'actions' => array('create', 'update', 'delete'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionCreate()
    {
        $model = new CommunityRubric;

        if (isset($_POST['CommunityRubric'])) {
            $model->attributes = $_POST['CommunityRubric'];


            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getPost('id');
            $model = $this->loadModel($id);
            if (Yii::app()->authManager->checkAccess('изменение рубрик в темах', Yii::app()->user->getId(), array(
                'community_id'=>$model->community_id
            ))) {
                $model->name = Yii::app()->request->getPost('text');
                if ($model->save()) {
                    echo CJSON::encode(array(
                        'status' => true
                    ));
                    Yii::app()->end();
                }
            }
        }
        echo CJSON::encode(array(
            'status' => false,
        ));
    }

    public function actionDelete()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getPost('id');
            $model = $this->loadModel($id);
            if (Yii::app()->authManager->checkAccess('изменение рубрик в темах', Yii::app()->user->getId(), array(
                'community_id'=>$model->community_id
            ))) {
                $themesCount = $model->getCount();
                if ($themesCount == 0) {
                    echo CJSON::encode(array(
                        'status' => $model->delete()
                    ));
                    Yii::app()->end();
                }
            }
        }
        echo CJSON::encode(array(
            'status' => false,
        ));
    }

    /**
     * @param $id
     * @return CommunityRubric
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        if ($this->_model === null) {
            if (isset($id))
                $this->_model = CommunityRubric::model()->findbyPk($id);
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        return $this->_model;
    }
}
