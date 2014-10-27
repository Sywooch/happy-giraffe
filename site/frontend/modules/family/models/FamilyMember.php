<?php

namespace site\frontend\modules\family\models;

/**
 * This is the model class for table "family__members".
 *
 * The followings are the available columns in table 'family__members':
 * @property string $id
 * @property string $type
 * @property string $name
 * @property integer $gender
 * @property string $birthday
 * @property string $description
 * @property string $userId
 * @property string $familyId
 * @property integer $removed
 *
 * The followings are the available model relations:
 * @property \User $user
 * @property \site\frontend\modules\family\models\Family $family
 */
class FamilyMember extends \HActiveRecord
{
    const GENDER_FEMALE = 0;
    const GENDER_MALE = 1;

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

    protected function instantiate($attributes)
    {
        switch ($attributes['type']) {
            case 'adult':
                $class = '\site\frontend\modules\family\models\Adult';
                break;
            case 'child':
                $class = '\site\frontend\modules\family\models\Child';
                break;
            case 'planning':
                $class = '\site\frontend\modules\family\models\PlanningChild';
                break;
            case 'waiting':
                $class = '\site\frontend\modules\family\models\PregnancyChild';
                break;
            case 'waitingTwins':
                $class = '\site\frontend\modules\family\models\PregnancyTwins';
                break;
            default:
                throw new \CException('Wrong type');
        }
        $model = new $class(null);
        return $model;
    }

    protected function beforeValidate()
    {
        $validateCanBeAdded = $this->isNewRecord && $this->scenario != 'familyCreate';

        if ($validateCanBeAdded && ! $this->canBeAdded()) {
            throw new \CException('Этого члена семьи нельзя добавить в семью');
        }

        return parent::beforeValidate();
    }

    protected function canBeAdded()
    {
        return true;
    }

    public function family($familyId)
    {
        $this->getDbCriteria()->compare($this->getTableAlias() . '.familyId', $familyId);
        return $this;
    }

    public function user($userId)
    {
        $this->getDbCriteria()->compare($this->getTableAlias() . '.userId', $userId);
        return $this;
    }

    public function gender($gender)
    {
        $this->getDbCriteria()->compare($this->getTableAlias() . '.gender', $gender);
        return $this;
    }

    public function type($type)
    {
        if (is_array($type)) {
            $this->getDbCriteria()->addInCondition($this->getTableAlias() . '.type', $type);
        } else {
            $this->getDbCriteria()->compare($this->getTableAlias() . '.type', $type);
        }
        return $this;
    }
}
