<?php

class DefaultController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

	public function actionChangeIdentity($userId = null)
	{
        if ($userId !== null) {
            $identity = new DevelopesUserIdentity($userId);
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity);
                $this->redirect(array('/site/index'));
            } else {
                echo $identity->errorMessage;
            }
        }

		$this->render('index');
	}
}