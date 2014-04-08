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
    public function actionAuth($redirectUrl, $hash)
	{
        if (Yii::app()->user->isGuest) {
            $identity = new MailTokenUserIdentity($hash);
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity);
            }
        }

        $this->redirect(urldecode($redirectUrl));
	}

    public function actionDialogues()
    {
        $sender = new MailSenderDialogues();
        $sender->sendAll();
    }
}