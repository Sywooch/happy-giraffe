<?php

class DefaultController extends HController
{
    /**
     * Аутентификация
     *
     * Аутентифицирует гостя в случае наличия активного токена и переадресует на нужную страницу
     *
     * @param $redirectUrl
     * @param $hash
     */
    public function actionRedirect($redirectUrl, $tokenHash, $deliveryHash)
	{
        if (Yii::app()->user->isGuest) {
            $identity = new MailTokenUserIdentity($tokenHash);
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity);
            }
        }

        $delivery = MailDelivery::model()->findByAttributes(array(
            'hash' => $deliveryHash,
            'sent' => null,
        ));
        if ($delivery !== null) {
            $delivery->clicked();
        }

        $this->redirect(urldecode($redirectUrl));
	}

    public function actionDialogues()
    {
        $sender = new MailSenderDialogues();
        $sender->sendAll();
    }
}