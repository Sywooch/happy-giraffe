<?php
/**
 * Форма обработки 2 шага регистрация
 *
 * Имеет 2 сценария (insert и social), в зависимости от того прошел ли пользователь первый шаг через социальную сеть
 * или e-mail. Сохраняет пользователя вместе с сопутствующими моделями, а так же выполняет набор действий, которые
 * необходимо выполнить сразу после регистрации.
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

    private $_password;

    public function rules()
    {
        return array(
            array('first_name, last_name, email, birthday, gender, country_id, birthday_day, birthday_month, birthday_year', 'required'),
            array('email', 'email'),
            array('email', 'unique', 'className' => 'User', 'caseSensitive' => false, 'criteria' => array('condition' => 'deleted = 0 AND status = :inactive', 'params' => array(':inactive' => User::STATUS_ACTIVE))),
            array('birthday', 'date', 'format' => 'yyyy-M-d'),
            array('verifyCode', 'CaptchaExtendedValidator', 'allowEmpty'=> ! CCaptcha::checkRequirements() || YII_DEBUG, 'except' => 'social', 'captchaAction' => '/signup/register/captcha'),

            //address
            array('city_id', 'default', 'value' => null),
            array('city_id', 'cityRequired'),
            array('country_id', 'exist', 'className' => 'GeoCountry', 'attributeName' => 'id'),
            array('city_id', 'exist', 'className' => 'GeoCity', 'attributeName' => 'id'),

            array('service, service_id, avatar', 'safe'),
        );
    }

    /**
     * Город обязателен для заполнения только в том случае, если города выбранной страны есть в базе и для нее
     * установлен соответствующий флажок
     *
     * @param $attribute
     * @param $params
     */
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
        $this->_password = User::createPassword(8);
        $this->password = User::hashPassword($this->_password);
        $this->activation_code = $this->createActivationCode();

        if ($this->getScenario() == 'social') {
            $socialService = new UserSocialService();
            $socialService->attributes = $this->attributes;
            $this->_user->userSocialServices = array($socialService);
        }

        $address = new UserAddress();
        $address->attributes = $this->attributes;
        if ($address->city !== null)
            $address->region_id = $address->city->region_id;
        $this->_user->address = $address;

        if ($this->_user->withRelated->save(true, array('userSocialServices', 'address'))) {
            if ($this->avatar) {
                $photo = AlbumPhoto::createByUrl($this->avatar['imgSrc'], $this->id);
                if ($photo) {
                    $coordinates = $this->avatar['coords'];
                    UserAvatar::createUserAvatar($this->id, $photo->id, $coordinates['x'], $coordinates['y'], $coordinates['w'], $coordinates['h']);
                }
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

        SignupEmailHelper::register($this->_user, $this->_password);

        Yii::app()->user->returnUrl = Yii::app()->request->getUrlReferrer();
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