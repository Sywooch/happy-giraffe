<?php

class UserRolesController extends BController
{
    public $layout = 'shop';
    public $defaultAction = 'admin';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('user access'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['User']['group'])){
            $model->group = $_POST['User']['group'];
            $model->save();
        }

        if (isset($_POST['User'])) {
            //clear all
            $assignments = Yii::app()->authManager->getAuthAssignments($model->id);
            foreach ($assignments as $assignment)
                Yii::app()->authManager->revoke($assignment->itemName, $model->id);

            //assign role
            if (isset($_POST['User']['role']) && !empty($_POST['User']['role']))
                Yii::app()->authManager->assign($_POST['User']['role'], $model->id);

            //assign operations
            if (isset($_POST['Operation']))
                foreach ($_POST['Operation'] as $key => $value) {
                    if ($value == 1) {
                        if (isset($_POST['community_id'])
                            && !empty($_POST['community_id'])
                            && ($key == 'editCommunityContent' || $key == 'removeCommunityContent')
                        )
                            Yii::app()->authManager->assign($key, $model->id,
                                'return $params["community_id"] == ' . $_POST['community_id'] . ';');
                        else
                            Yii::app()->authManager->assign($key, $model->id);
                    }
                }
            $this->redirect('/userRoles/admin');
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * @param $id
     * @return User
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = User::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionChangePassword()
    {
        $id = Yii::app()->request->getPost('id');
        $model = $this->loadModel($id);

        $password = $this->createPassword(12);
        $model->password = $model->hashPassword($password);

        if ($model->save('password')) {
            $response = array(
                'status' => true,
                'result' => $model->id.' - '.$model->getFullName().'. Новый пароль: '.$password
            );
        } else
            $response = array('status' => false);
        var_dump($model->getErrors());
        echo CJSON::encode($response);
    }

    function createPassword($length) {
        $chars = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $i = 0;
        $password = "";
        while ($i <= $length) {
            $password .= $chars{mt_rand(0,strlen($chars) - 1)};
            $i++;
        }
        return $password;
    }
}
