<?php
/**
 * @author Никита
 * @date 23/03/15
 */

namespace site\frontend\modules\pages\controllers;


use site\frontend\modules\pages\widgets\contactFormWidget\models\AttachForm;
use site\frontend\modules\pages\widgets\contactFormWidget\models\ContactForm;

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionSend(array $attributes)
    {
        $model = new ContactForm();
        $model->attributes = $attributes;
        $model->save();
        $this->success = true;
    }

    public function actionCreateAttachment()
    {
        $form = new AttachForm();
        $form->file = \CUploadedFile::getInstanceByName('file');
        $this->data = $form->save();
        $this->success = true;
    }
}