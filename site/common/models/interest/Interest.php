<?php

/**
 * This is the model class for table "interest".
 *
 * The followings are the available columns in table 'interest':
 * @property string $id
 * @property string $title
 * @property string $category_id
 *
 * The followings are the available model relations:
 * @property InterestCategory $category
 * @property User[] $users
 */
class Interest extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Interest the static model class
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
        return 'interest__interests';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('title', 'required'),
            array('title', 'length', 'max' => 255),
            array('category_id', 'length', 'max' => 2),
            array('id, title, category_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'category' => array(self::BELONGS_TO, 'InterestCategory', 'category_id'),
            'users' => array(self::MANY_MANY, 'User', 'interest__users_interests(interest_id, user_id)'),
            'usersCount' => array(self::STAT, 'User', 'interest__users_interests(interest_id, user_id)'),
        );
    }

    /**
     * Добавляет или удаляет интерес
     * @param int $user_id
     * @param int $interest_id
     * @return int
     */
    public static function toggleInterest($user_id, $interest_id)
    {
        $exist = Yii::app()->db->createCommand()
            ->select('user_id')
            ->from('interest__users_interests')
            ->where('user_id=:user_id AND interest_id=:interest_id ', array(
                ':interest_id' => $interest_id,
                ':user_id' => $user_id,
            ))
            ->queryScalar();
        if ($exist)
            return Yii::app()->db->createCommand()->delete('interest__users_interests',
                'user_id=:user_id AND interest_id=:interest_id', array(
                    ':interest_id' => $interest_id,
                    ':user_id' => $user_id,
                ));
        else {
            if (self::userInterestsCount($user_id) < 25)
                return Yii::app()->db->createCommand()->insert('interest__users_interests', array(
                    'interest_id' => $interest_id,
                    'user_id' => $user_id,
                ));
            else
                return false;
        }
    }

    public static function userInterestsCount($user_id)
    {
        return Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from('interest__users_interests')
            ->where('user_id=:user_id', array(':user_id' => $user_id))
            ->queryScalar();
    }

    /**
     * Возвращает нескольких пользователей с этим интересом для knockout модели
     * @param int $limit
     * @return array
     */
    public function getUsersData($limit = 6)
    {
        $userIds = Yii::app()->db->createCommand()
            ->select('user_id')
            ->from('interest__users_interests')
            ->where('interest_id = :interest_id', array(':interest_id' => $this->id))
            ->limit($limit)
            ->queryColumn();

        $users = User::model()->with('avatar')->findAllByPk($userIds);
        $data = array();
        foreach ($users as $user)
            $data[] = array(
                'url' => $user->getUrl(),
                'ava' => $user->getAva(),
                'gender' => $user->gender,
            );

        return $data;
    }
}