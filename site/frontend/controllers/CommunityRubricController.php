<?php

class CommunityRubricController extends HController
{
    public $layout = '//layouts/column2';
    private $_model;

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly'
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
        $model->title = Yii::app()->request->getPost('name');
        $attr = Yii::app()->request->getPost('attr');
        $model->$attr= Yii::app()->request->getPost('attr_value');

        //if ((Yii::app()->authManager->checkAccess('editCommunityRubric', Yii::app()->user->id, array(
        //    'community_id' => $model->community_id
        //)))
        //) {
            if ($model->save()) {
                echo CJSON::encode(array(
                    'status' => true,
                    //'html' => $this->renderPartial('/community/parts/rubric_item', array(
                    //    'r' => $model,
                    //    'type' => Yii::app()->request->getPost('type'),
                    //    'current_rubric' => null,
                    //), true)
                ));
                Yii::app()->end();
            }
        //}

        echo CJSON::encode(array(
            'status' => false,
        ));
    }

    public function actionUpdate()
    {
        $id = Yii::app()->request->getPost('id');
        $model = $this->loadModel($id);
        //if (Yii::app()->authManager->checkAccess('editCommunityRubric', Yii::app()->user->id, array(
        //    'community_id' => $model->community_id
        //))
        //) {
            $model->title = Yii::app()->request->getPost('name');
            if ($model->save()) {
                echo CJSON::encode(array(
                    'status' => true
                ));
                Yii::app()->end();
            }
        //}
        echo CJSON::encode(array(
            'status' => false,
        ));
    }

    public function actionDelete()
    {
        $id = Yii::app()->request->getPost('id');
        $model = $this->loadModel($id);
        if (Yii::app()->authManager->checkAccess('editCommunityRubric', Yii::app()->user->id, array(
            'community_id' => $model->community_id
        ))
        ) {
            $themesCount = $model->getCount();
            if ($themesCount == 0) {
                echo CJSON::encode(array(
                    'status' => $model->delete()
                ));
                Yii::app()->end();
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
