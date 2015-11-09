<?php

/**
 * This is the model class for table "qa__consultations_consultants".
 *
 * The followings are the available columns in table 'qa__consultations_consultants':
 * @property string $id
 * @property string $consultationId
 * @property string $name
 * @property string $title
 * @property string $userId
 * @property string $text
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property QaConsultations $consultation
 */
class QaConsultant extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qa__consultations_consultants';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('consultationId, userId, text', 'required'),
			array('consultationId, userId', 'length', 'max'=>11),
			array('name, title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, consultationId, name, title, userId, text', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'userId'),
			'consultation' => array(self::BELONGS_TO, 'QaConsultations', 'consultationId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'consultationId' => 'Consultation',
			'name' => 'Name',
			'title' => 'Title',
			'userId' => 'User',
			'text' => 'Text',
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
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('consultationId',$this->consultationId,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QaConsultant the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
