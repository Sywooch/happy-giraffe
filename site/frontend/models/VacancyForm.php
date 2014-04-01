<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 01/04/14
 * Time: 12:53
 * To change this template use File | Settings | File Templates.
 */

class VacancyForm extends CFormModel
{
    public $fullName;
    public $email;
    public $phoneNumber;
    public $hhUrl;

    public function rules()
    {
        return array(
            array('fullName, email, phoneNumber, hhUrl', 'required'),
            array('email', 'email'),
            array('phoneNumber', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', 'message' => 'Контактный телефон не является корректным номером телефона'),
            array('')
        );
    }

    public function validateLink()
    {

    }

    public function attributeLabels()
    {
        return array(
            'fullName' => 'Имя, фамилия',
            'email' => 'E-mail',
            'phoneNumber' => 'Контактный <br>телефон',
            'hhUrl' => 'Ссылка на резюме <br> на HeadHunter',
        );
    }

    public function send()
    {
        return true;
    }
}