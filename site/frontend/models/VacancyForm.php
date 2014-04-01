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
            array('phoneNumber', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', 'message' => 'Введите корректный номер телефона'),
            array('hhUrl', 'validateLink'),
        );
    }

    public function validateLink($attribute, $params)
    {
        $parts = parse_url($this->$attribute);
        if ($parts === false || ! isset($parts['host']) || $parts['host'] != 'hh.ru') {
            $this->addError($attribute, 'Введите корректную ссылку на ваше резюме');
        }
    }

    public function cityRequired($attribute, $params)
    {
        if ($this->country_id) {
            $country = GeoCountry::model()->findByPk($this->country_id);
            if ($country->citiesFilled) {
                $req = CValidator::createValidator('required', $this, array('city_id'));
                $req->validate($this);
            }
        }
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
        $emails = array('nikita@happy-giraffe.ru', 'info@happy-giraffe.ru');
        foreach ($emails as $e) {
            $html = Yii::app()->controller->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . 'vacancy.php', array('form' => $this), true);
            ElasticEmail::send($e, 'Отклик на вакансию PHP-разработчика, ' . $this->fullName, $html, 'noreply@happy-giraffe.ru', 'Веселый Жираф');
        }
    }
}