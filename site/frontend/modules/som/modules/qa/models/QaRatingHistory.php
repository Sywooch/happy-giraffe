<?php
namespace site\frontend\modules\som\modules\qa\models;

/**
 * This is the model class for table "qa__rating_history".
 *
 * The followings are the available columns in table 'qa__rating_history':
 * @property int $user_id
 * @property int $category_id
 * @property int $created_at
 * @property string $owner_model
 * @property int $owner_id
 *
 * The followings are the available model relations:
 * @property \User $user
 * @property \site\frontend\modules\som\modules\qa\models\QaCategory $category
 */
class QaRatingHistory extends \CActiveRecord
{
    public $points;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'qa__rating_history';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id,category_id,owner_model,owner_id', 'required'),
            array('category_id', 'exist', 'attributeName' => 'id', 'className' => get_class(QaCategory::model())),
            array('user_id', 'exist', 'attributeName' => 'id', 'className' => get_class(\User::model())),
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
            'category' => array(self::BELONGS_TO, get_class(QaCategory::model()), 'category_id'),
            'user' => array(self::BELONGS_TO, get_class(\User::model()), 'user_id'),
        );
    }

    public function behaviors()
    {
        return array(
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'created_at',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
            'created_at' => 'Created',
            'owner_model' => 'Owner',
            'owner_id' => 'Onwer ID',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return QaRatingHistory the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param string $modelName
     * @return QaRatingHistory
     */
    public function byModel($modelName)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.owner_model', $modelName);
        return $this;
    }

    /**
     * @param string $ownerModel
     * @param int $ownerId
     * @return QaRatingHistory
     */
    public function byOwner($ownerModel, $ownerId)
    {
        $this->getDbCriteria()
            ->compare($this->tableAlias . '.owner_model', $ownerModel)
            ->compare($this->tableAlias . '.owner_id', $ownerId);
        return $this;
    }

    /**
     * @param int $userId
     * @return QaRatingHistory
     */
    public function byUser($userId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.user_id', $userId);
        return $this;
    }

    /**
     * @param int $categoryId
     * @return QaRatingHistory
     */
    public function byCategory($categoryId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.category_id', $categoryId);
        return $this;
    }

    /**
     * @param int $start
     * @param int $end
     * @return QaRatingHistory
     */
    public function between($start, $end)
    {
        $this->getDbCriteria()->addBetweenCondition($this->tableAlias . '.created_at', $start, $end);
        return $this;
    }

    /**
     * @return QaRatingHistory
     */
    public function notSpecialist()
    {
        if (!isset($this->getDbCriteria()->with['user'])) {
            $this->getDbCriteria()->with[] = 'user';
        }

        $this->getDbCriteria()->addCondition('user.specialistInfo is null or user.specialistInfo = \'\'');

        return $this;
    }

    /**
     * @return QaRatingHistory
     */
    public function forSpecialists()
    {
        if (!isset($this->getDbCriteria()->with['user'])) {
            $this->getDbCriteria()->with[] = 'user';
        }

        $this->getDbCriteria()->addCondition('user.specialistInfo is not null and user.specialistInfo != \'\'');

        return $this;
    }
}
