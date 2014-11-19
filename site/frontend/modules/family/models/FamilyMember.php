<?php

namespace site\frontend\modules\family\models;

/**
 * This is the model class for table "family__members".
 *
 * The followings are the available columns in table 'family__members':
 * @property int $id
 * @property string $type
 * @property string $name
 * @property int $gender
 * @property string $birthday
 * @property string $description
 * @property int $userId
 * @property int $familyId
 * @property int $created
 * @property int $updated
 * @property int $removed
 *
 * The followings are the available model relations:
 * @property \site\frontend\components\api\models\User $user
 * @property \site\frontend\modules\family\models\Family $family
 */
class FamilyMember extends \HActiveRecord implements \IHToJSON
{
    const GENDER_FEMALE = '0';
    const GENDER_MALE = '1';

    const TYPE_ADULT = 'adult';
    const TYPE_CHILD = 'child';
    const TYPE_PLANNING = 'planning';
    const TYPE_WAITING = 'waiting';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'family__members';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
        return array(
            array('type', 'in', 'range' => array(
                self::TYPE_ADULT,
                self::TYPE_CHILD,
                self::TYPE_PLANNING,
                self::TYPE_WAITING,
            ), 'allowEmpty' => false, 'on' => 'insert'),
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
			'family' => array(self::BELONGS_TO, '\site\frontend\modules\family\models\Family', 'familyId'),
		);
	}

    public function apiRelations()
    {
        return array(
            'user' => array('site\frontend\components\api\ApiRelation', 'site\frontend\components\api\models\User', 'userId'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'name' => 'Name',
			'gender' => 'Gender',
			'birthday' => 'Birthday',
			'description' => 'Description',
			'userId' => 'User',
			'familyId' => 'Family',
            'created' => 'Created',
            'updated' => 'Updated',
			'removed' => 'Removed',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FamilyMember the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'softDelete' => array(
                'class' => 'site.common.behaviors.SoftDeleteBehavior',
            ),
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
            'PhotoCollectionBehavior' => array(
                'class' => 'site\frontend\modules\photo\components\PhotoCollectionBehavior',
            ),
        );
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'type' => $this->type,
        );
    }

    public function defaultScope()
    {
        $t = $this->getTableAlias(false, false);
        return array(
            'condition' => $t . '.removed = 0',
        );
    }

    public function scopes()
    {
        return array(
            'virtual' => array(
                'condition' => 'userId IS NULL',
            ),
            'real' => array(
                'condition' => 'userId IS NOT NULL',
            ),
        );
    }

    /**
     * @param int $familyId id семьи
     * @return FamilyMember $this
     */
    public function family($familyId)
    {
        $this->getDbCriteria()->compare($this->getTableAlias() . '.familyId', $familyId);
        return $this;
    }

    /**
     * @param int $userId id пользователя
     * @return FamilyMember $this
     */
    public function user($userId)
    {
        $this->getDbCriteria()->compare($this->getTableAlias() . '.userId', $userId);
        return $this;
    }

    /**
     * @param int $gender пол
     * @return FamilyMember $this
     */
    public function gender($gender)
    {
        $this->getDbCriteria()->compare($this->getTableAlias() . '.gender', $gender);
        return $this;
    }

    /**
     * @param string $type тип члена семьи
     * @return FamilyMember $this
     */
    public function type($type)
    {
        if (is_array($type)) {
            $this->getDbCriteria()->addInCondition($this->getTableAlias() . '.type', $type);
        } else {
            $this->getDbCriteria()->compare($this->getTableAlias() . '.type', $type);
        }
        return $this;
    }

    /**
     * Синхронизировать информацию
     *
     * Синхронизирует информацию о члене семьи с информацией реальзого пользователя.
     *
     * @param int $userId id пользователя
     * @return FamilyMember $this
     */
    public function fillByUser($userId)
    {
        $user = \site\frontend\components\api\models\User::model()->findByPk($userId);
        $this->name = $user->firstName;
        $this->gender = $user->gender;
        $this->userId = $userId;
        return $this;
    }

    protected function instantiate($attributes)
    {
        $class = self::getClassName($attributes['type']);
        $model = new $class(null);
        return $model;
    }

    /**
     * Возвращает класс, реализующий членов семьи переданного типа
     *
     * @param string $type тип члена семьи
     * @return string класс
     * @throws \CException если передано некорректное значение типа
     */
    public static function getClassName($type)
    {
        switch ($type) {
            case 'adult':
                return '\site\frontend\modules\family\models\Adult';
            case 'child':
                return '\site\frontend\modules\family\models\Child';
            case 'planning':
                return '\site\frontend\modules\family\models\PlanningChild';
            case 'waiting':
                return '\site\frontend\modules\family\models\PregnancyChild';
            default:
                throw new \CException('Invalid type value');
        }
    }

    protected function beforeValidate()
    {
        $validateCanBeAdded = $this->isNewRecord && $this->scenario != 'familyCreate';

        if ($validateCanBeAdded && ! $this->canBeAdded()) {
            throw new \CException('Этого члена семьи нельзя добавить в семью');
        }

        return parent::beforeValidate();
    }

    /**
     * @return bool может ли быть добавлен данный член семьи
     */
    protected function canBeAdded()
    {
        return true;
    }

    /**
     * @return bool является ли член семьи публичныи
     */
    public function isPublic()
    {
        $oldScenario = $this->scenario;
        $this->scenario = 'show';
        $result = $this->validate();
        $this->scenario = $oldScenario;
        return $result;
    }

    public function getEntityName()
    {
        $reflect = new \ReflectionClass(__CLASS__);
        return $reflect->getShortName();
    }
}
