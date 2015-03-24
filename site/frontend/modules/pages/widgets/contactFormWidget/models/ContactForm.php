<?php
namespace site\frontend\modules\pages\widgets\contactFormWidget\models;

/**
 * @author Никита
 * @date 23/03/15
 */

class ContactForm extends \CFormModel
{
    const SEND_TO = 'nikita@happy-giraffe.ru';
    const SEND_FROM = 'noreply@happy-giraffe.ru';

    public $message;
    public $name;
    public $companyName;
    public $email;
    public $phone;
    public $attachId = false;

    public function rules()
    {
        return array(
            array('message, name, companyName, email, phone, attachId', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'message' => 'Сообщение',
            'name' => 'Имя',
            'companyName' => 'Компания',
            'email' => 'Email',
            'phone' => 'Телефон',
            'attachId' => 'Приложение',
        );
    }

    public function save()
    {
        return \ElasticEmail::send(self::SEND_TO, 'Обратная связь с ВЖ', $this->getHtml(), self::SEND_FROM, $this->name . ', ' . $this->companyName, $this->attachId);
    }

    protected function getHtml()
    {
        $html = '';
        $html .= $this->message;
        $html .= '<br><br>';
        $attributes = array('name', 'companyName', 'email', 'phone');
        foreach ($attributes as $a) {
            $html .= \CHtml::openTag('strong') . $this->getAttributeLabel($a) . ': ' . \CHtml::closeTag('strong') . ' ' . $this->$a . '<br>';
        }
        return $html;
    }
}