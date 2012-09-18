<?php

class CheckController extends ELController
{

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('externalLinks-manager-panel'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

	public function actionIndex()
	{
        $models = ELLink::model()->findAll('check_link_time < "'.date("Y-m-d H:i:s") .'" AND check_link_time IS NOT NULL');

		$this->render('index', compact('models'));
	}

    public function actionChecked(){
        $link = $this->loadModel(Yii::app()->request->getPost('id'));
        $success = Yii::app()->request->getPost('success');
        if ($success)
            echo CJSON::encode(array('status' => $link->nextCheckTime()));
        else
            echo CJSON::encode(array('status' => $link->addToBlacklist()));
    }

    /**
     * @param int $id model id
     * @return ELLink
     * @throws CHttpException
     */
    public function loadModel($id){
        $model = ELLink::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}