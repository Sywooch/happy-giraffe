<?php

/**
 * This is the model class for table "user__community_subscriptions".
 *
 * The followings are the available columns in table 'user__community_subscriptions':
 * @property int $user_id
 * @property int $community_id
 */
class UserCommunitySubscription extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserCommunitySubscription the static model class
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
        return 'user__community_subscriptions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('user_id, community_id', 'required'),
            array('user_id', 'length', 'max' => 10),
            array('community_id', 'length', 'max' => 11),
            array('user_id, community_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'community' => array(self::BELONGS_TO, 'Community', 'community_id'),
        );
    }

    /**
     * возвращает всех подписчиков клуба
     *
     * @param int $community_id id клуба
     * @param int $limit
     * @return User[]
     */
    public function getSubscribers($community_id, $limit = 9)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('community_id', $community_id);
        $criteria->with = array('clubSubscriber');
        $criteria->limit = $limit;
        return User::model()->findAll($criteria);
    }

    /**
     * Возвращает количество подписчиков
     *
     * @param int $community_id
     * @return int
     */
    public function getSubscribersCount($community_id)
    {
        return Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from($this->tableName())
            ->where('community_id=:community_id', array(':community_id' => $community_id))
            ->queryScalar();
    }

    /**
     * Возвращает список id клубов, на которые подписан
     *
     * @param int $user_id
     * @return int[]
     */
    public static function getSubUserCommunities($user_id)
    {
        return Yii::app()->db->createCommand()
            ->select('community_id')
            ->from(self::model()->tableName())
            ->where('user_id=:user_id', array(':user_id' => $user_id))
            ->queryColumn();
    }

    /**
     * Меняет подписку на клуб - если нет - добалвяет, если есть - удаляет
     *
     * @param int $community_id
     * @return bool успех
     */
    public static function toggle($community_id)
    {
        $model = self::model()->find('user_id=:user_id AND community_id=:community_id', array(
            ':user_id' => Yii::app()->user->id,
            ':community_id' => $community_id,
        ));
        return $model === null ? self::add($community_id) : $model->delete();
    }

    /**
     * Отписать пользователя user от клубы
     * @param int $user_id
     * @param int $community_id
     * @return bool успех
     */
    public static function unSubscribe($user_id, $community_id)
    {
        $model = self::model()->find('user_id=:user_id AND community_id=:community_id', array(
            ':user_id' => $user_id,
            ':community_id' => $community_id,
        ));
        return $model !== null ? true : $model->delete();
    }

    /**
     * Подписан ли user на клуб
     *
     * @param int $user_id
     * @param int $community_id
     * @return bool успех
     */
    public static function subscribed($user_id, $community_id)
    {
        $model = self::model()->find('user_id=:user_id AND community_id=:community_id', array(
            ':user_id' => $user_id,
            ':community_id' => $community_id,
        ));
        return $model !== null;
    }

    /**
     * Добавляет подписку на клуб
     *
     * @param int $community_id
     * @return bool успех
     */
    public static function add($community_id)
    {
        $model = new self;
        $model->user_id = Yii::app()->user->id;
        $model->community_id = $community_id;
        return $model->save();
    }

    /**
     * сообщества, на которые не подписан
     *
     * @param int $user_id
     * @return int[]
     */
    public static function notSubscribedClubIds($user_id)
    {
        $all_club_ids = Yii::app()->db->cache(3600)->createCommand()
            ->select('id')
            ->from('community__communities')
            ->queryColumn();

        $subscribed_ids = self::getSubUserCommunities($user_id);
        return array_diff($all_club_ids, $subscribed_ids);
    }
}