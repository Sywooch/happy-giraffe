<?php

/**
 * This is the model class for table "user__club_subscriptions".
 *
 * The followings are the available columns in table 'user__club_subscriptions':
 * @property int $user_id
 * @property int $club_id
 */
class UserClubSubscription extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserClubSubscription the static model class
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
        return 'user__club_subscriptions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('user_id, club_id', 'required'),
            array('user_id', 'length', 'max' => 10),
            array('club_id', 'length', 'max' => 11),
            array('user_id, club_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'club' => array(self::BELONGS_TO, 'CommunityClub', 'club_id'),
        );
    }

    /**
     * возвращает всех подписчиков клуба
     *
     * @param int $club_id id клуба
     * @param int $limit
     * @return User[]
     */
    public function getSubscribers($club_id, $limit = 9)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('club_id', $club_id);
        $criteria->with = array('clubSubscriber');
        $criteria->limit = $limit;
        return User::model()->findAll($criteria);
    }

    /**
     * Возвращает количество подписчиков
     *
     * @param int $club_id
     * @return int
     */
    public function getSubscribersCount($club_id)
    {
        $add = array(
            1 => 8820,
            2 => 40580,
            3 => 36000,
            4 => 35000,
            5 => 10000,
            6 => 8600,
            7 => 39000,
            8 => 15000,
            9 => 10500,
            10 => 7000,
            11 => 1350,
            12 => 20500,
            13 => 1130,
            14 => 5300,
            15 => 16000,
            16 => 39000,
            17 => 9500,
            18 => 5300,
            19 => 0,
            20 => 6400,
            21 => 4600,
            22 => 10000,
        );
        $count = Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from($this->tableName())
            ->where('club_id=:club_id', array(':club_id' => $club_id))
            ->queryScalar();

        return $count + $add[$club_id];
    }

    /**
     * Меняет подписку на клуб - если нет - добалвяет, если есть - удаляет
     *
     * @param int $club_id
     * @return bool успех
     */
    public static function toggle($club_id)
    {
        $model = self::model()->find('user_id=:user_id AND club_id=:club_id', array(
            ':user_id' => Yii::app()->user->id,
            ':club_id' => $club_id,
        ));
        return $model === null ? self::add($club_id) : $model->delete();
    }

    /**
     * Отписать пользователя user от клубы
     * @param int $user_id
     * @param int $club_id
     * @return bool успех
     */
    public static function unSubscribe($user_id, $club_id)
    {
        $model = self::model()->find('user_id=:user_id AND club_id=:club_id', array(
            ':user_id' => $user_id,
            ':club_id' => $club_id,
        ));
        return $model !== null ? true : $model->delete();
    }

    /**
     * Подписан ли user на клуб
     *
     * @param int $user_id
     * @param int $club_id
     * @return bool успех
     */
    public static function subscribed($user_id, $club_id)
    {
        $model = self::model()->find('user_id=:user_id AND club_id=:club_id', array(
            ':user_id' => $user_id,
            ':club_id' => $club_id,
        ));
        return $model !== null;
    }

    /**
     * Добавляет подписку на клуб
     *
     * @param int $club_id
     * @param null $user_id
     * @return bool успех
     */
    public static function add($club_id, $user_id = null)
    {
        if (empty($user_id))
            $user_id = Yii::app()->user->id;
        $model = new UserClubSubscription;
        $model->user_id = $user_id;
        $model->club_id = $club_id;
        return $model->save();
    }
}