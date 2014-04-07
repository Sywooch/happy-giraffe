<?php
/**
 * Форма отправки заявки на вакансию PHP-разработчика
 * @property array $emails
 */

class VacancyForm extends CFormModel
{
    public $fullName;
    public $email;
    public $phoneNumber;
    public $hhUrl;

    private $debugEmails = array('pavel@happy-giraffe.ru', 'nikita@happy-giraffe.ru');
    private $productionEmails = array('info@happy-giraffe.ru');

    public function getEmails()
    {
        return YII_DEBUG ? $this->debugEmails : $this->productionEmails;
    }

    public function rules()
    {
        return array(
            array('fullName, email, phoneNumber', 'required'),
            array('email', 'email'),
            array('phoneNumber', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', 'message' => 'Введите корректный номер телефона'),
            array('hhUrl', 'validateLink'),
        );
    }

    public function validateLink($attribute, $params)
    {
        if (empty($this->$attribute))
            return;

        $parts = parse_url($this->$attribute);
        if ($parts === false || ! isset($parts['host']) || strpos($parts['host'], 'hh.ru') != (strlen($parts['host']) - 5)) {
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
        foreach ($this->emails as $e) {
            $html = Yii::app()->controller->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . 'vacancy.php', array('form' => $this), true);
            ElasticEmail::send($e, 'Отклик на вакансию PHP-разработчика, ' . $this->fullName, $html, 'noreply@happy-giraffe.ru', 'Веселый Жираф');
        }
    }
}