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
 * @property integer $related_user_id
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property SeoTask[] $tasks
 * @property TempKeyword[] $tempKeywords
 * @property SeoUser $owner
 * @property SeoUser[] $users
 * @property Commentator[] $commentators
 */
class SeoUser extends HActiveRecord
{
    public $current_password;
    public $remember;
    public $role;
    public $task_count = null;

    /**
     * Returns the static model of the specified AR class.
     * @return SeoUser the static model class
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
        return 'users';
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
            array('related_user_id', 'numerical', 'integerOnly' => true),
            array('email, related_user_id', 'unique'),
            array('id, role, owner_id, active', 'safe'),
            array('related_user_id', 'unsafe'),
            //login
            array('email, password', 'required', 'on' => 'login'),
            array('password', 'passwordValidator', 'on' => 'login'),
        );
    }

    public function validatePassword($attribute, $params)
    {
        if ($this->password !== $this->hashPassword($this->current_password)) $this->addError('password', 'Текущий пароль введён неверно.');

    }

    public function afterFind()
    {
        $roles = array_shift(Yii::app()->authManager->getAuthItems(2, $this->id));
        if (!empty($roles))
            $this->role = $roles->name;

        parent::afterFind();
    }

    public function passwordValidator($attribute, $params)
    {
        if ($this->password == '' || $this->email == '')
            return false;
        $userModel = $this->find(array(
            'condition' => 'email=:email AND password=:password',
            'params' => array(
                ':email' => $_POST['SeoUser']['email'],
                ':password' => $this->hashPassword($_POST['SeoUser']['password']),
            )));
        if ($userModel) {
            $identity = new SeoUserIdentity($userModel->getAttributes());
            $identity->authenticate();
            if ($identity->errorCode == SeoUserIdentity::ERROR_NONE) {
                $duration = $this->remember == 1 ? 2592000 : 0;
                Yii::app()->user->login($identity, $duration);
                $userModel->save(false);
            } else {
                $this->addError('password', 'Ошибка авторизации');
            }
        } else {
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

    public function beforeSave()
    {
        if (empty($this->related_user_id)) {
            $frontend_model_id = Yii::app()->db->createCommand()
                ->select('id')
                ->from(User::model()->tableName())
                ->where('email = :email', array(':email' => $this->email))
                ->queryScalar();

            if ($frontend_model_id !== null) {
                $this->related_user_id = $frontend_model_id;
            }
        }

        return parent::beforeSave();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'tasks' => array(self::HAS_MANY, 'SeoTask', 'user_id'),
            'tempKeywords' => array(self::HAS_MANY, 'TempKeyword', 'owner_id'),
            'owner' => array(self::BELONGS_TO, 'SeoUser', 'owner_id'),
            'authors' => array(self::HAS_MANY, 'SeoUser', 'owner_id'),
            'commentators' => array(self::HAS_MANY, 'Commentators', 'manager_id'),
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
            'active' => 'Активен',
        );
    }

    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => $this->getTableAlias(false, false) . '.active = 1'
            ),
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
            'pagination' => array('pageSize' => 100),
        ));
    }

    public function beforeValidate()
    {
        if (empty($this->owner_id))
            $this->owner_id = null;

        return parent::beforeValidate();
    }

    public function hashPassword($password)
    {
        return md5($password);
    }

    /**
     * @return User
     */
    public function getRelatedUser()
    {
        if (!empty($this->related_user_id)) {
            $user = User::model()->findByPk($this->related_user_id);

            return $user;
        }

        return null;
    }

    public function getAva($size = 'small')
    {
        $user = $this->getRelatedUser();
        if ($user != null) {
            return $user->getAva($size);
        }
    }

    public function commentatorIds()
    {
        $result = array();
        foreach ($this->commentators as $commentator)
            $result [] = $commentator->id;

        return $result;
    }

    public function getTasksCount()
    {
        if ($this->task_count === null){
            $this->task_count = SeoTask::model()->count('executor_id=' . $this->id . ' AND status >= ' . SeoTask::STATUS_READY
            . ' AND status <= ' . SeoTask::STATUS_TAKEN);
            return $this->task_count;
        }
        return $this->task_count;
    }

    public static function getSmoUsers()
    {
        $users = Yii::app()->db_seo->createCommand()
            ->select('userId')
            ->from('auth__assignments')
            ->where('itemname = "externalLinks-manager" OR itemname = "externalLinks-worker"')
            ->queryColumn();

        return SeoUser::model()->findAllByPk($users);
    }

    public static function getContentManagers()
    {
        $users = Yii::app()->db_seo->createCommand()
            ->select('userId')
            ->from('auth__assignments')
            ->where('itemname = "content-manager" OR itemname = "cook-content-manager"')
            ->queryColumn();

        return SeoUser::model()->findAllByPk($users);
    }

    public function getWorkers($role = 'cook-author')
    {
        $result = array();
        $users = SeoUser::model()->active()->findAll('owner_id = '.Yii::app()->user->id);
        foreach ($users as $author)
            if (Yii::app()->authManager->checkAccess($role, $author->id)){
                $result [] = $author;
            }

        return $result;
    }
}