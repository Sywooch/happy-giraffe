<?php
/**
 * Class RegisterFormStep2
 * @property User $user
 */

class RegisterFormStep2 extends CFormModel
{
    public $first_name;
    public $last_name;
    public $email;
    public $birthday;
    public $birthday_day;
    public $birthday_month;
    public $birthday_year;
    public $gender;
    public $verifyCode;
    public $avatar;

    //address
    public $country_id;
    public $city_id;

    //socialService
    public $service;
    public $service_id;

    private $_user;

    public function rules()
    {
        return array(
            array('first_name, last_name, email, birthday, gender, country_id, city_id', 'required'),
            array('birthday_day, birthday_month, birthday_year, service, service_id, avatar', 'safe'),
            array('birthday', 'date', 'format' => 'yyyy-M-d'),
            array('country_id', 'exist', 'className' => 'GeoCountry', 'attributeName' => 'id'),
            array('city_id', 'exist', 'className' => 'GeoCity', 'attributeName' => 'id'),
            array('verifyCode', 'CaptchaExtendedValidator', 'allowEmpty'=> ! CCaptcha::checkRequirements(), 'except' => 'social'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'email' => 'E-mail',
            'birthday' => 'Дата рождения',
            'gender' => 'Пол',
            'verifyCode' => 'Код проверки',

            //address
            'country_id' => 'Страна',
            'city_id' => 'Город',
        );
    }

    public function setUser($user)
    {
        $this->_user = $user;
    }

    public function getUser()
    {
        return $this->_user;
    }

    protected function createActivationCode()
    {
        return sha1(mt_rand(10000, 99999) . time() . $this->email);
    }

    public function save()
    {
        $this->_user->attributes = $this->attributes;
        $password = User::createPassword(8);
        $this->password = User::hashPassword($password);
        $this->activation_code = $this->createActivationCode();

        if ($this->getScenario() == 'social') {
            $socialService = new UserSocialService();
            $socialService->attributes = $this->attributes;
            $this->_user->userSocialServices = array($socialService);
        }

        $address = new UserAddress();
        $address->attributes = $this->attributes;
        $this->_user->address = $address;

        if ($this->_user->withRelated->save(true, array('userSocialServices', 'address'))) {
            if ($this->avatar) {
                $photo = AlbumPhoto::createByUrl($this->avatar['imgSrc'], $this->id);
                $coordinates = $this->avatar['coords'];
                UserAvatar::createUserAvatar($this->id, $photo->id, $coordinates['x'], $coordinates['y'], $coordinates['w'], $coordinates['h']);
            }

            $this->afterSave();
            return true;
        }
        return false;
    }

    protected function beforeValidate()
    {
        if ($this->birthday_day && $this->birthday_month && $this->birthday_year)
            $this->birthday = implode('-', array($this->birthday_year, $this->birthday_month, $this->birthday_day));
        return parent::beforeValidate();
    }

    protected function afterSave()
    {
        //рубрика для блога
        $rubric = new CommunityRubric;
        $rubric->title = 'Обо всём';
        $rubric->user_id = $this->id;
        $rubric->save();

        Yii::import('site.frontend.modules.myGiraffe.models.*');
        ViewedPost::getInstance($this->id);

        Friend::model()->addCommentatorAsFriend($this->id);

        //create some tables
        Yii::app()->db->createCommand()->insert(UserPriority::model()->tableName(), array('user_id' => $this->id));
        Yii::app()->db->createCommand()->insert(UserScores::model()->tableName(), array('user_id' => $this->id));

        Yii::app()->email->send($this, 'confirmEmail', array(
            'password' => $this->password,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'activation_url' => Yii::app()->createAbsoluteUrl('/signup/register/confirm', array('activationCode' => $this->activation_code)),
        ));
    }

    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (CException $e) {
            return $this->_user->$name;
        }
    }

    public function __set($name, $value)
    {
        try {
            parent::__set($name, $value);
        } catch (CException $e) {
            $this->_user->$name = $value;
        }
    }
}