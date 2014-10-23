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
 * @property string $adultRelationshipStatus
 *
 * The followings are the available model relations:
 * @property \User $user
 * @property \site\frontend\modules\family\models\Family $family
 */
class FamilyMember extends \HActiveRecord
{
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

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, '\User', 'userId'),
			'family' => array(self::BELONGS_TO, '\site\frontend\modules\family\modelsFamily', 'familyId'),
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
			'adultRelationshipStatus' => 'Adult Relationship Status',
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
}
