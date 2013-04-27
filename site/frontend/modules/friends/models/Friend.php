<?php

/**
 * This is the model class for table "friends".
 *
 * The followings are the available columns in table 'friends':
 * @property string $id
 * @property string $user_id
 * @property string $friend_id
 * @property string $created
 * @property string $list_id
 *
 * The followings are the available model relations:
 * @property FriendsLists $list
 * @property Users $user
 * @property Users $friend
 */
class Friend extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Friend the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'friends';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, friend_id, created', 'required'),
            array('user_id, friend_id, list_id', 'length', 'max'=>11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, friend_id, created, list_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'list' => array(self::BELONGS_TO, 'FriendsList', 'list_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'friend' => array(self::BELONGS_TO, 'User', 'friend_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'friend_id' => 'Friend',
            'created' => 'Created',
            'list_id' => 'List',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('friend_id',$this->friend_id,true);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('list_id',$this->list_id,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getCountByUserId($userId, $online = false)
    {
        $criteria = new CDbCriteria();

        if ($online) {
            $criteria->with = 'friend';
            $criteria->addCondition('friend.online = 1');
        }

        return $this->countByAttributes(array('user_id' => $userId), $criteria);
    }
}