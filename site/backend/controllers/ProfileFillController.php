<?php

class ProfileFillController extends BController
{
    public $layout = 'shop';
    public $defaultAction = 'admin';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('user access'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $users = AuthAssignment::model()->findAll('itemname="moderator" OR itemname="virtual user" ');
        $ids = array();
        foreach ($users as $user) {
            $ids[] = $user->userid;
        }

        $criteria = new CDbCriteria;
        $criteria->condition = ' profile_check IS NULL ';
        $criteria->compare('id', $ids);
        $criteria->mergeWith($model->search()->getCriteria());

        $dataProvider = new CActiveDataProvider('User', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 1000),
        ));
        $this->render('admin', array(
            'dataProvider' => $dataProvider,
            'model' => $model
        ));
    }

    public function actionAccept()
    {
        Yii::import('site.frontend.modules.scores.models.*');
        $id = Yii::app()->request->getPost('id');
        $user = $this->loadModel($id);
        $user->profile_check = 1;
        if ($user->update(array('profile_check'))) {
            $response = array(
                'status' => true,
            );
        } else {
            $response = array('status' => false);
        }

        echo CJSON::encode($response);

    }

    public function loadModel($id)
    {
        $model = User::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}
