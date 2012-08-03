<?php

class User extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className
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
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'userAddress' => array(self::HAS_ONE, 'UserAddress', 'user_id'),
            'interests' => array(self::MANY_MANY, 'Interest', 'interest__users_interests(interest_id, user_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
        );
    }

    public function afterSave()
    {
        //Yii::app()->cache->delete('User_' . $this->id);
        $cacheKey='yii:dbquery'.Yii::app()->db->connectionString.':'.Yii::app()->db->username;
        $cacheKey.=':'.'SELECT * FROM `users` `t` WHERE `t`.`id`=\''.$this->id.'\' LIMIT 1:a:0:{}';
        Yii::app()->cache->delete($cacheKey);
    }

    public static function getUserById($id)
    {
        $user = User::model()->findByPk($id);
        return $user;
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFriendSelectCriteria()
    {
        return new CDbCriteria(array(
            'join' => 'JOIN ' . Friend::model()->tableName() . ' ON (t.id = friends.user1_id AND friends.user2_id = :user_id) OR (t.id = friends.user2_id AND friends.user1_id = :user_id)',
            'params' => array(':user_id' => $this->id),
        ));
    }

    public function isNewComer()
    {
        return false;
    }

    public function getUserAddress()
    {
        if ($this->userAddress === null) {
            $address = new UserAddress();
            $address->user_id = $this->id;
            $address->save();
            $this->userAddress = $address;
        }
        return $this->userAddress;
    }
}