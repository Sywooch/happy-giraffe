<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property integer $owner_id
 *
 * The followings are the available model relations:
 * @property SeoTask[] $tasks
 * @property TempKeywords[] $tempKeywords
 * @property User $owner
 * @property User[] $users
 */
class User extends HActiveRecord
{
    public $current_password;
    public $remember;
    public $role;

    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'happy_giraffe_seo.users';
    }

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            //general
            array('name, email', 'length', 'max' => 50),
            array('email', 'unique'),
            //login
            array('email, password', 'required', 'on' => 'login'),
            array('password', 'passwordValidator', 'on' => 'login'),
        );
    }

    public function validatePassword($attribute, $params)
    {
        if ($this->password !== $this->hashPassword($this->current_password)) $this->addError('password', 'Текущий пароль введён неверно.');

    }

    public function passwordValidator($attribute, $params)
    {
        if ($this->password == '' || $this->email == '')
            return false;
        $userModel = $this->find(array(
            'condition' => 'email=:email AND password=:password',
            'params' => array(
                ':email' => $_POST['User']['email'],
                ':password' => $this->hashPassword($_POST['User']['password']),
            )));
        if ($userModel) {
            $identity = new UserIdentity($userModel->getAttributes());
            $identity->authenticate();
            if ($identity->errorCode == UserIdentity::ERROR_NONE) {
                $duration = $this->remember == 1 ? 2592000 : 0;
                Yii::app()->user->login($identity, $duration);
                $userModel->save(false);
            }
            else {
                $this->addError('password', 'Ошибка авторизации');
            }
        }
        else {
            $this->addError('password', 'Ошибка авторизации');
        }
    }

    public function checkUserPassword($attribute, $params)
    {
        $userModel = $this->find(array('condition' => 'email="' . $this->email . '" AND password="' . $this->hashPassword($this->password) . '"'));
        if (!$userModel) {
            $this->addError($attribute, 'Не найден пользователь с таким именем и паролем');
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'tasks' => array(self::HAS_MANY, 'SeoTask', 'user_id'),
            'tempKeywords' => array(self::HAS_MANY, 'TempKeywords', 'owner_id'),
            'owner' => array(self::BELONGS_TO, 'User', 'owner_id'),
            'authors' => array(self::HAS_MANY, 'User', 'owner_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Имя',
            'email' => 'Логин',
            'password' => 'Пароль',
            'gender' => 'Пол',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    public function hashPassword($password)
    {
        return md5($password);
    }
}