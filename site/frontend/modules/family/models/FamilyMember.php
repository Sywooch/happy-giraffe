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
 *
 * The followings are the available model relations:
 * @property \User $user
 * @property \site\frontend\modules\family\models\Family $family
 */
class FamilyMember extends \CActiveRecord
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
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
			'family' => array(self::BELONGS_TO, 'Family', 'familyId'),
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
}
