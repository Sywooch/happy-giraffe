<?php

/**
 * This is the model class for table "age_range".
 *
 * The followings are the available columns in table 'age_range':
 * @property string $range_id
 * @property string $range_title
 * @property string $range_order
 */
class AgeRange extends CActiveRecord {

	const GENDER_ALL	= 0;
	const GENDER_MALE	= 1;
	const GENDER_FEMALE = 2;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return AgeRange the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'age_ranges';
	}
	
	public function primaryKey() {
		return 'id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title', 'length', 'max' => 50),
			array('position', 'length', 'max' => 10),
			array('position', 'default', 'value' => 0),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, position', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => '№',
			'title' => 'Заголовок',
			'position' => 'Порядок',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->range_id, true);
		$criteria->compare('title', $this->range_title, true);
		$criteria->compare('position', $this->range_order, true);

		return new CActiveDataProvider($this, array(
					'criteria' => $criteria,
				));
	}

	public function defaultScope() {
		return array(
			'order' => 'position ASC, id DESC',
		);
	}
	/**
	 * Get ages. Return array
	 * @return array
	 */
	public function getAgesArray() {
		$criteria = new CDbCriteria();
		$criteria->order = 'position ASC';
		$ages = $this->findAll($criteria);
		$return = array();
		foreach ($ages as $a) {
			$pk = $this->primaryKey();
			$return[$a->$pk] = $a->attributes;
		}
		return $return;
	}
	
	/**
	 * Get gender list array
	 * @return array
	 */
	public function getGenderList() { 
		return array(
			self::GENDER_ALL	=> 'Для всех',
			self::GENDER_MALE	=> 'Мальчик',
			self::GENDER_FEMALE => 'Девочка'
		);
	}
	
	/**
	 * Get gender by $id
	 * @param int $id 
	 * @return string|null
	 */
	public function getGender($id) {
		$list = $this->getGenderList();
		return (isset($list[$id])) ? $list[$id] : null;
	}

}