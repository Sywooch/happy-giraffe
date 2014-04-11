<?php

class DefaultController extends HController
{
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
        $photo = AlbumPhoto::model()->findByPk(326229);
        echo CHtml::image($photo->getPreviewUrl(660, null, Image::WIDTH));
    }
}