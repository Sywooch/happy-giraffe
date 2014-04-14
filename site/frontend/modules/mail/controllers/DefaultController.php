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

        $imageUrl = $photo->getPreviewPath(660, null, Image::WIDTH);
        $image = new Image($imageUrl, array('driver' => 'GD', 'params' => array()));
        $watermarkUrl = Yii::getPathOfAlias('webroot') . '/new/images/mail/water-mark.png';
        $watermark = new Image($watermarkUrl);
        $image->watermark($watermark, 80, ($image->width - 151) / 2, ($image->height - 151) / 2);
        $image->save(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '2.jpg');
        echo CHtml::image('/2.jpg');
    }
}