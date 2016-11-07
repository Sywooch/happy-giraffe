<?php
namespace site\frontend\modules\som\modules\qa\models;

/**
 * This is the model class for table "qa__rating".
 *
 * The followings are the available columns in table 'qa__rating':
 * @property int $user_id
 * @property int $category_id
 * @property int $answers_count
 * @property int $votes_count
 * @property int $total_count
 *
 * The followings are the available model relations:
 * @property \User $user
 * @property \site\frontend\modules\som\modules\qa\models\QaCategory $category
 */
class QaRating extends \HActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'qa__rating';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id,category_id', 'required'),
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
            'user' => array(self::BELONGS_TO, 'site\frontend\modules\users\models\User', 'user_id'),
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
            'answers_count' => 'Answers',
            'votes_count' => 'Votes',
            'total_count' => 'Total',
        );
    }

    public function behaviors()
    {
        return array(
            'CacheDelete' => array(
                'class' => \site\frontend\modules\api\ApiModule::CACHE_DELETE,
            ),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return QaRating the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param int $categoryId
     * @return QaRating
     */
    public function byCategory($categoryId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.category_id', $categoryId);
        return $this;
    }

    /**
     * @param int $userId
     * @return QaRating
     */
    public function byUser($userId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.user_id', $userId);
        return $this;
    }

    /**
     * @return QaRating
     */
    public function notSpecialist()
    {
        if (!isset($this->getDbCriteria()->with['user'])) {
            $this->getDbCriteria()->with[] = 'user';
        }

        $this->getDbCriteria()->addCondition('user.specialistInfo is null or user.specialistInfo = \'\'');

        return $this;
    }
}
