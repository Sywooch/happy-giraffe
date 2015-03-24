<?php
namespace site\frontend\modules\pages\widgets\contactFormWidget;
use site\frontend\modules\pages\widgets\contactFormWidget\models\ContactForm;

/**
 * @author Никита
 * @date 23/03/15
 */

class ContactFormWidget extends \CWidget
{
    public function run()
    {
        $model = new ContactForm();
        $this->render('_form', compact('model'));
    }
}