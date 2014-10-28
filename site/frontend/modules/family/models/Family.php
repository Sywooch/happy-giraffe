<?php

namespace site\frontend\modules\family\models;

/**
 * This is the model class for table "family__families".
 *
 * The followings are the available columns in table 'family__families':
 * @property string $id
 * @property string $description
 * @property string $adultsRelationshipStatus
 * @property string $created
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\family\models\FamilyMember[] $members
 */
class Family extends \CActiveRecord implements \IHToJSON
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'family__families';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
            array('description', 'length', 'max' => 500),
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
			'members' => array(self::HAS_MANY, '\site\frontend\modules\family\models\FamilyMember', 'familyId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'description' => 'Description',
            'adultRelationshipStatus' => 'Adult Relationship Status',
            'created' => 'Created',
            'updated' => 'Updated',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Family the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'withRelated' => array(
                'class' => 'site.common.extensions.wr.WithRelatedBehavior',
            ),
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
        );
    }

    public function canEdit()
    {
        return FamilyMember::model()->family($this->id)-user(\Yii::app()->user->id)->exists();
    }

    public static function getByUserId($userId)
    {
        $family = Family::model()->find(array(
            'with' => array(
                'members' => array(
                    'scopes' => array(
                        'user' => $userId,
                    ),
                )
            )
        ));
        if ($family !== null) {
            return $family;
        }

        $family = self::createFamily($userId);
        return ($family === false) ? null : $family;
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'description' => $this->description,
            'members' => $this->members,
        );
    }

    public function canManage($userId)
    {
        return FamilyMember::model()->user($userId)->family($this->id)->exists();
    }

    protected static function createFamily($userId)
    {
        $family = new Family();
        $member = new Adult();
        $member->fillByUser($userId);
        $family->members = array($member);
        $success = $family->withRelated->save(true, array('members'));
        return ($success) ? $family : false;
    }
}
