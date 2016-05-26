<?php

/**
 * This is the model class for table "blacklist".
 *
 * The followings are the available columns in table 'blacklist':
 * @property string $user_id
 * @property string $blocked_user_id
 */
class Blacklist extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Blacklist the static model class
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
        return 'blacklist';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, blocked_user_id', 'required'),
            array('user_id, blocked_user_id', 'length', 'max'=>11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, blocked_user_id', 'safe', 'on'=>'search'),
        );
    }

    public function behaviors()
    {
        return array(
            'CacheDelete' => array(
                'class' => site\frontend\modules\api\ApiModule::CACHE_DELETE,
            ),
            'PushStream' => array(
                'class' => site\frontend\modules\api\ApiModule::PUSH_STREAM,
            ),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'blocked_user_id' => 'Blocked User',
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

        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('blocked_user_id',$this->blocked_user_id,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function isBlocked($userId, $blockedUserId)
    {
        return Blacklist::model()->exists('user_id = :user_id AND blocked_user_id = :blocked_user_id', array(
            ':user_id' => $userId,
            ':blocked_user_id' => $blockedUserId,
        ));
    }

    public static function addToBlackList($userId, $blockedUserId)
    {
        $model = new Blacklist();
        $model->user_id = $userId;
        $model->blocked_user_id = $blockedUserId;
        $success = $model->save();

        if ($success) {
            $comet = new CometModel();
            $comet->attributes = array('userId' => $userId, 'blockedUserId' => $blockedUserId);
            $comet->type = CometModel::BLACKLIST_ADDED;
            $comet->send($userId);
            $comet->send($blockedUserId);
        }

        return $success;
    }

    public static function removeFromBlackList($userId, $blockedUserId)
    {
        $success = self::model()->deleteAllByAttributes(array(
            'user_id' => $userId,
            'blocked_user_id' => $blockedUserId,
        )) > 0;

        if ($success) {
            $comet = new CometModel();
            $comet->attributes = array('userId' => $userId, 'blockedUserId' => $blockedUserId);
            $comet->type = CometModel::BLACKLIST_REMOVED;
            $comet->send($userId);
            $comet->send($blockedUserId);
        }

        return $success;
    }
}