<?php

class DefaultController extends HController
{
    /**
     * Аутентификация
     *
     * Аутентифицирует гостя в случае наличия активного токена и переадресует на нужную страницу
     *
     * @param $redirectUrl
     * @param $token
     */
    public function actionAuth($redirectUrl, $token)
	{
        die;

        if (Yii::app()->user->isGuest) {
            $identity = new MailTokenUserIdentity($token);
            if ($identity->authenticate()) {
                Yii::app()->user->login($token);
            }
        }

        $this->redirect($redirectUrl);
	}

    public function actionDialogues()
    {

    }
}