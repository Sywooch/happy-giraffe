<?php

/**
 * This is the model class for table "user__blog_subscriptions".
 *
 * The followings are the available columns in table 'user__blog_subscriptions':
 * @property string $user_id
 * @property string $user2_id
 *
 * The followings are the available model relations:
 * @property User $user2
 * @property User $user
 */
class UserBlogSubscription extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserBlogSubscription the static model class
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
        return 'user__blog_subscriptions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('user_id, user2_id', 'required'),
            array('user_id', 'length', 'max' => 10),
            array('user2_id', 'length', 'max' => 11),
            array('user_id, user2_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'user2' => array(self::BELONGS_TO, 'User', 'user2_id'),
        );
    }

    /**
     * возвращает всех подписчиков блога
     *
     * @param int $user_id id автора блога
     * @return User[]
     */
    public function getSubscribers($user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('user2_id', $user_id);
        $criteria->with = array('subscriber', 'avatar');
        $criteria->limit = 10;
        return User::model()->findAll($criteria);
    }

    /**
     * возвращает количество подписчиков блога
     *
     * @param int $user_id id автора блога
     * @return int
     */
    public function subscribersCount($user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('user2_id', $user_id);
        $criteria->with = array('subscriber');
        return User::model()->count($criteria);
    }

    /**
     * Возвращает список id юзеров, на блоги которых одписан
     *
     * @param int $user_id
     * @return int[]
     */
    public function getSubUserIds($user_id)
    {
        return Yii::app()->db->createCommand()
            ->select('user2_id')
            ->from($this->tableName())
            ->where('user_id=:user_id', array(':user_id' => $user_id))
            ->queryColumn();
    }

    /**
     * Меняет подписку на блог - если нет - добалвяет, если есть - удаляет
     *
     * @param int $user2_id id пользователя, на блог которого подписываемся
     * @return bool успех
     */
    public static function toggle($user2_id)
    {
        $model = self::model()->find('user_id=:user_id AND user2_id=:user2_id', array(
            ':user_id' => Yii::app()->user->id,
            ':user2_id' => $user2_id,
        ));
        return $model !== null ? self::add($user2_id) : $model->delete();
    }

    /**
     * Отписать пользователя user от блога user2
     * @param int $user_id
     * @param int $user2_id
     * @return bool успех
     */
    public static function unSubscribe($user_id, $user2_id)
    {
        $model = self::model()->find('user_id=:user_id AND user2_id=:user2_id', array(
            ':user_id' => $user_id,
            ':user2_id' => $user2_id,
        ));
        return $model !== null ? true : $model->delete();
    }

    /**
     * Подписан ли user на блог пользователя user2
     *
     * @param int $user_id
     * @param int $user2_id
     * @return bool успех
     */
    public static function subscribed($user_id, $user2_id)
    {
        $model = self::model()->find('user_id=:user_id AND user2_id=:user2_id', array(
            ':user_id' => $user_id,
            ':user2_id' => $user2_id,
        ));
        return $model !== null;
    }

    /**
     * Добавляет подписку на блог
     *
     * @param int $user2_id id пользователя, на блог которого подписываемся
     * @return bool успех
     */
    public static function add($user2_id)
    {
        $model = new self;
        $model->user_id = Yii::app()->user->id;
        $model->user2_id = $user2_id;
        return $model->save();
    }
}