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
 * @property FriendList $list
 * @property User $user
 * @property User $friend
 */
class Friend extends HActiveRecord
{
    public $pCount;
    public $bCount;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Friend the static model class
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
            array('user_id, friend_id', 'required'),
            array('user_id, friend_id, list_id', 'length', 'max' => 11),
            array('created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, friend_id, created, list_id', 'safe', 'on' => 'search'),
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
            'list' => array(self::BELONGS_TO, 'FriendList', 'list_id'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('friend_id', $this->friend_id, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('list_id', $this->list_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getCountByUserId($userId, $online = false, $new = false)
    {
        $criteria = new CDbCriteria();

        if ($online) {
            $criteria->with = 'friend';
            $criteria->addCondition('friend.online = 1');
        }

        if ($new)
            $criteria->addCondition('t.created >= DATE_ADD(CURDATE(), INTERVAL -3 DAY)');

        return $this->countByAttributes(array('user_id' => $userId), $criteria);
    }

    public function areFriends($user1Id, $user2Id)
    {
        return
            Friend::model()->exists('user_id = :user1Id AND friend_id = :user2Id', array(
                ':user1Id' => $user1Id,
                ':user2Id' => $user2Id,
            ))
            &&
            Friend::model()->exists('user_id = :user2Id AND friend_id = :user1Id', array(
                ':user1Id' => $user1Id,
                ':user2Id' => $user2Id,
            ));
    }

    public function makeFriendship($user1Id, $user2Id)
    {
        $f1 = new Friend();
        $f1->user_id = $user1Id;
        $f1->friend_id = $user2Id;

        $f2 = new Friend();
        $f2->user_id = $user2Id;
        $f2->friend_id = $user1Id;

        if (!$f1->validate() || !$f2->validate())
            return false;

        if (Yii::app()->db->getCurrentTransaction() === null) {
            $transaction = Yii::app()->db->beginTransaction();
        }
        try {
            $f1->save();
            $f2->save();

            if (isset($transaction)) {
                $transaction->commit();
            }

            Scoring::friendAdded($user1Id, $user2Id);
            MessagingThread::model()->findOrCreate($user1Id, $user2Id);
            $comet = new CometModel();
            $comet->attributes = array('user1Id' => $user1Id, 'user2Id' => $user2Id);
            $comet->type = CometModel::FRIEND_ADDED;
            $comet->send($user1Id);
            $comet->send($user2Id);
            return true;
        } catch (Exception $e) {
            if (isset($transaction)) {
                $transaction->rollback();
            }
            return false;
        }
    }

    public function breakFriendship($user1Id, $user2Id)
    {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            Friend::model()->deleteAll('user_id = :user_id AND friend_id = :friend_id', array(':user_id' => $user1Id, ':friend_id' => $user2Id));
            Friend::model()->deleteAll('user_id = :user_id AND friend_id = :friend_id', array(':user_id' => $user2Id, ':friend_id' => $user1Id));

            $transaction->commit();
            Scoring::friendRemoved($user1Id, $user2Id);
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

    /**
     * Добавить пользователю комментатора в друзья
     * @param int $user_id
     */
    public function addCommentatorAsFriend($user_id)
    {
        Yii::import('site.frontend.modules.signal.helpers.*');
        if ($this->getCountByUserId($user_id) > 1)
            return ;

        $commentator_ids = CommentatorHelper::getCommentatorIdList();
        shuffle($commentator_ids);
        foreach($commentator_ids as $commentator_id)
            if (!$this->areFriends($commentator_id, $user_id)){
                $this->makeFriendship($commentator_id, $user_id);
                break;
            }
    }

    public function behaviors()
    {
        return array(
            'site\frontend\modules\posts\modules\myGiraffe\behaviors\SubscriptionBehavior',
        );
    }
}