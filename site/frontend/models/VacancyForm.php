<?php
/**
 * Форма отправки заявки на вакансию PHP-разработчика
 * @property array $emails
 */

class VacancyForm extends CFormModel
{
    public $fullName = 'Василий Пупкин';
    public $email = 'vasya.pupkin@gmail.com';
    public $phoneNumber = '+7 (905) 363-53-73';
    public $hhUrl;
    public $cvUrl;

    private $debugEmails = array('pavel@happy-giraffe.ru', 'nikita@happy-giraffe.ru');
    private $productionEmails = array('info@happy-giraffe.ru', 'pavel@happy-giraffe.ru', 'nikita@happy-giraffe.ru');

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
            array('cvUrl', 'url'),
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

    public function attributeLabels()
    {
        return array(
            'fullName' => 'Имя, фамилия',
            'email' => 'E-mail',
            'phoneNumber' => 'Контактный <br>телефон',
            'hhUrl' => 'Ссылка на резюме <br> на HeadHunter',
            'cvUrl' => 'Ссылка на загруженное резюме',
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