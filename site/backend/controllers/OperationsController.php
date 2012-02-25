<?php

class OperationsController extends BController
{
    public $layout = 'shop';
	public $defaultAction='admin';

    public function beforeAction($action)
    {
//        if (!Yii::app()->user->checkAccess('user access'))
//            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

	public function actionCreate()
	{
		$model=new AuthItem;

		if(isset($_POST['AuthItem']))
		{
			$model->attributes=$_POST['AuthItem'];
            $model->type = AuthItem::TYPE_OPERATION;
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['AuthItem']))
		{
			$model->attributes=$_POST['AuthItem'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$model=new AuthItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AuthItem']))
			$model->attributes=$_GET['AuthItem'];
        $model->type = AuthItem::TYPE_OPERATION;

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=AuthItem::model()->find('name="'.$id.'" AND type = '.AuthItem::TYPE_OPERATION);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
