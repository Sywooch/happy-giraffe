<?php

/**
 * This is the model class for table "geo_rus_settlement".
 *
 * The followings are the available columns in table 'geo_rus_settlement':
 * @property string $id
 * @property string $name
 * @property string $district_id
 * @property string $region_id
 * @property string $population
 */
class GeoRusSettlement extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GeoRusSettlement the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'geo__rus_settlement';
	}
	
	public function primaryKey() {
		return 'id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, region_id', 'required'),
			array('name', 'length', 'max'=>255),
			array('district_id, region_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, district_id, region_id', 'safe'),
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
		    'region' => array(self::BELONGS_TO, 'GeoRusRegion', 'region_id'),
		    'district' => array(self::BELONGS_TO, 'GeoRusDistrict', 'district_id'),
		    'cityReg' => array(self::HAS_ONE, 'GeoRusSettlement', 'settlement_id','through'=>'region'),
            'type' => array(self::BELONGS_TO, 'GeoRusSettlementType', 'type_id'),
//		    'cityDist' => array(self::HAS_ONE, 'GeoRusSettlement', 'id','through'=>'district'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'district_id' => 'District',
			'region_id' => 'Region',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('district_id',$this->district_id,true);
		$criteria->compare('region_id',$this->region_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function getCities($district_id=null, $region_id=null) {
	    $vid = md5(__CLASS__ . __FUNCTION__ . $district_id . "-" .$region_id);
	    $value = Yii::app()->cache->get($vid);
	    if (!$value) {
			$carr = array();
			$carr1 = array();
			$carr2 = array();

			if ($region_id) {
				$models = $this->findAll('((region_id=' . $region_id.'))');
				foreach ($models as $model) {
					$carr1[$model->id] = $model->name;
				}
				asort($carr1, SORT_STRING);
				$carr = $carr1;// + $carr2;
			}
			$value = $carr;
			Yii::app()->cache->set($vid, $value, 86400);
	    } 
	    return $value;
	}
	
	public function getCity() {
	    $vid = md5(__CLASS__ . __FUNCTION__ . $this->id);
	    $value = Yii::app()->cache->get($vid);
	    if (!$value) {
			$model = $this->findByPk($this->id);
			$value[$model->id] = $model->name;
			Yii::app()->cache->set($vid, $value, 86400);
	    } 
	    return $value;
	}

	public function getSettlementName() {
	    if (isset($this->name)) {
			return $this->name;
	    } 
		else {
			return false;
	    }
	}
}