<?php

namespace site\frontend\modules\specialists\models;

/**
 * This is the model class for table "specialists__specializations".
 *
 * The followings are the available columns in table 'specialists__specializations':
 * @property string $id
 * @property string $title
 * @property string $groupId
 *
 * The followings are the available model relations:
 * @property SpecialistProfile[] $specialistsProfiles
 * @property SpecialistGroup[] $group
 */
class SpecialistSpecialization extends \CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'specialists__specializations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
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
			'profiles' => array(self::MANY_MANY, 'site\frontend\modules\specialists\models\SpecialistProfile', 'specialists__profiles_specializations(specializationId, profileId)'),
			'group' => array(self::BELONGS_TO, 'site\frontend\modules\specialists\models\SpecialistGroup', 'groupId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'groupId' => 'Group',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return \CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new \CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('groupId',$this->groupId,true);

		return new \CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SpecialistSpecialization the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function sorted()
	{
		$this->getDbCriteria()->order = 'sort DESC';
		return $this;
	}

	/**
	 * @param int $groupId
	 *
	 * @return SpecialistSpecialization
	 */
	public function byGroup($groupId)
	{
		$this->getDbCriteria()->compare($this->getTableAlias() . '.groupId', $groupId);

		return $this;
	}
}
