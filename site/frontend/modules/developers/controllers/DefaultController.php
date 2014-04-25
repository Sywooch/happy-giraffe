<?php

class DefaultController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

//    public function accessRules()
//    {
//        return array(
//            array('allow',
//                'roles' => array('developersModule'),
//            ),
//            array('deny',
//                'users' => array('*'),
//            ),
//        );
//    }

	public function actionChangeIdentity($userId = null)
	{
        var_dump(Yii::app()->user->checkAccess('developersModule'));

        if ($userId !== null) {
            $identity = new DevelopesUserIdentity($userId);
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity);
                $this->redirect(array('site/index'));
            } else {
                echo $identity->errorMessage;
            }
        }

		$this->render('index');
	}
}