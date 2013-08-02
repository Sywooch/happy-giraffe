<?php

/**
 * This is the model class for table "score__users_awards".
 *
 * The followings are the available columns in table 'score__users_awards':
 * @property string $id
 * @property string $user_id
 * @property string $award_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $user
 * @property ScoreAward $award
 */
class ScoreUserAward extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ScoreUserAward the static model class
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
        return 'score__users_awards';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, award_id', 'required'),
            array('user_id, award_id', 'length', 'max' => 10),
            array('created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, award_id, created', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'award' => array(self::BELONGS_TO, 'ScoreAward', 'award_id'),
        );
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            ),
        );
    }

    public function afterSave()
    {
        ScoreInputAward::getInstance()->add($this->user_id, $this);
        parent::afterSave();
    }

    public function getTitle()
    {
        if (empty($this->entity_id))
            return $this->award->title . ' ' . Yii::app()->dateFormatter->format('MMMM yyyy', strtotime($this->created) - 3600 * 24 * 2);
        else
            return $this->award->title;
    }

    /**
     * @param int $user_id
     * @return ScoreUserAward[]
     */
    public static function getUserAwards($user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('t.user_id', $user_id);
        $criteria->order = 't.id desc';
        $criteria->with = array('award');

        return self::model()->findAll($criteria);
    }

    /**
     * Возвращает модель награды
     * @return ScoreAward
     */
    public function getAward()
    {
        return $this->award;
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('/profile/default/award', array('id' => $this->id, 'user_id' => $this->user_id, 'type' => 'award'));
    }

    /**
     * Возвращает пользователей, которые также обладают этим трофеем
     * @return array
     */
    public function awardUsers()
    {
        $userIds = Yii::app()->db->createCommand()
            ->select('user_id')
            ->from($this->tableName())
            ->where('award_id=:award_id AND user_id != :user_id', array(':award_id' => $this->award_id, ':user_id' => $this->user_id))
            ->limit(33)
            ->queryColumn();
        $users = User::model()->with('avatar')->findAllByPk($userIds);

        $count = Yii::app()->db->createCommand()
            ->select('COUNT(DISTINCT user_id )')
            ->from($this->tableName())
            ->where('award_id=:award_id AND user_id != :user_id', array(':award_id' => $this->award_id, ':user_id' => $this->user_id))
            ->queryScalar();
        return array($users, $count);
    }
}