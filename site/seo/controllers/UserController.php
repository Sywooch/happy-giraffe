<?php

class UserController extends SController
{
    public $defaultAction = 'admin';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new User;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $password = '';

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $password = substr(md5(microtime()), 0, 8);
            $model->password = md5($password);

            if ($model->save()) {
                if (!empty($model->role)) {
                    Yii::app()->db_seo->createCommand()->delete('auth__assignments', 'userid=:userid', array(':userid' => $model->id));
                    Yii::app()->authManager->assign($model->role, $model->id);
                }

                $this->redirect($this->createUrl('/user/update', array('id' => $model->id)));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'password' => $password
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                Yii::app()->db_seo->createCommand()->delete('auth__assignments', 'userid=:userid', array(':userid' => $model->id));
                Yii::app()->authManager->assign($model->role, $model->id);
                $this->redirect($this->createUrl('/user/update', array('id' => $model->id)));
            }
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

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
    protected function performAjaxValidation($model)
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

        if ($model->save()) {
            $response = array(
                'status' => true,
                'result' => $model->email . ' '.$model->name. '. Новый пароль: ' . $password
            );
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    function createPassword($length)
    {
        $chars = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $i = 0;
        $password = "";
        while ($i <= $length) {
            $password .= $chars{mt_rand(0, strlen($chars) - 1)};
            $i++;
        }
        return $password;
    }
}
