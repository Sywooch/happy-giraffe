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
            array('allow',
                'roles' => array('tester'),
            ),
            array('deny',
                'users' => array('*'),
                'actions' => array('dialogues', 'daily'),
            ),
        );
    }

    /**
     * Редирект из почтовой рассылки
     *
     * Аутентифицирует гостя в случае наличия активного токена. Помечает запись о доставке как "кликнутую", в случае
     * если это еще не было сделано ранее.
     *
     * @param $redirectUrl
     * @param $tokenHash
     * @param $deliveryHash
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
            'clicked' => null,
        ));

        if ($delivery !== null) {
            $delivery->clicked();
        }

        $this->redirect(urldecode($redirectUrl));
	}

    public function actionDialogues()
    {
        $sender = new MailSenderDialogues();
        $sender->showForUser(Yii::app()->user->model);
    }

    public function actionDaily($date = null)
    {
        $sender = new MailSenderDaily($date);
        $sender->showForUser(Yii::app()->user->model);
    }
}