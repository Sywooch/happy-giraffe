<?php

class UserRolesController extends BController
{
    public $layout = 'shop';
	public $defaultAction='admin';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('управление правами пользователей'))
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
		$model=$this->loadModel($id);

		if(isset($_POST['User']))
		{
            //clear all
            $assignments = Yii::app()->authManager->getAuthAssignments($model->id);
            foreach($assignments as $assignment)
                Yii::app()->authManager->revoke($assignment->itemName, $model->id);

            //assign role
            if (isset($_POST['User']['role']) && !empty($_POST['User']['role']))
                    Yii::app()->authManager->assign($_POST['User']['role'], $model->id);

            //assign operations
            if (isset($_POST['Operation']))
                foreach ($_POST['Operation'] as $key => $value) {
                    if ($value == 1) {
                        if (isset($_POST['community_id']) && ($key =='изменение рубрик в темах' ||
                            $key =='редактирование тем в сообществах' || $key =='удаление тем в сообществах'))
                            Yii::app()->authManager->assign($key, $model->id,
                                'return $params["community_id"] == '.$_POST['community_id'].';');
                        else
                            Yii::app()->authManager->assign($key, $model->id);
                    }
                }
            $this->redirect('/userRoles/admin');
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
