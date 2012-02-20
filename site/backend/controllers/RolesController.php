<?php

class RolesController extends BController
{
    public $layout = 'shop';
	public $defaultAction='admin';

	public function actionCreate()
	{
		$model=new AuthItem;

		if(isset($_POST['AuthItem']))
		{
			$model->attributes=$_POST['AuthItem'];
            $model->type = AuthItem::TYPE_ROLE;
            if ($model->save()) {
                if (isset($_POST['Operation']))
                    foreach ($_POST['Operation'] as $key => $value) {
                        if ($value == 1) {
                            $item = new AuthItemChild();
                            $item->child = $key;
                            $item->parent = $model->name;
                            $item->save();
                        }
                    }
                $this->redirect(array('admin'));
            }
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
            if ($model->save()) {
                if (isset($_POST['Operation']))
                    foreach ($_POST['Operation'] as $key => $value) {
                        if ($value == 1) {
                            $item = new AuthItemChild();
                            $item->child = $key;
                            $item->parent = $model->name;
                            $item->save();
                        }
                    }
                $this->redirect(array('admin'));
            }
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
        $model->type = AuthItem::TYPE_ROLE;

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
        $model=AuthItem::model()->find('name="'.$id.'" AND type = '.AuthItem::TYPE_ROLE);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function SecretAction(){
        $users = User::model()->findAll();
        foreach($users as $user){
            if ($user->getRole() == 'user'){
//                $role =
            }
        }
    }
}
