<?php

/**
 * This is the model class for table "billing_system".
 *
 * The followings are the available columns in table 'billing_system':
 * @property integer $system_id
 * @property string $system_code
 * @property string $system_title
 * @property string $system_icon_file
 * @property string $system_params
 * @property integer $system_status
 */
class BillingSystem extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BillingSystem the static model class
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
		return 'billing__systems';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('system_id, system_status', 'numerical', 'integerOnly'=>true),
			array('system_code', 'length', 'max'=>16),
			array('system_title', 'length', 'max'=>64),
			array('system_icon_file', 'length', 'max'=>250),
			array('system_params', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('system_id, system_code, system_title, system_icon_file, system_params, system_status', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'system_id' => 'System',
			'system_code' => 'System Code',
			'system_title' => 'System Title',
			'system_icon_file' => 'System Icon File',
			'system_params' => 'System Params',
			'system_status' => 'System Status',
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

		$criteria->compare('system_id',$this->system_id);
		$criteria->compare('system_code',$this->system_code,true);
		$criteria->compare('system_title',$this->system_title,true);
		$criteria->compare('system_icon_file',$this->system_icon_file,true);
		$criteria->compare('system_params',$this->system_params,true);
		$criteria->compare('system_status',$this->system_status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	public function getParameters()
	{
		$params=array();
		parse_str(join('&',preg_split('#[\n\r]+#',trim($this->system_params," \n\r\t"))), $params);
		return $params;
	}
	public static function enum($fields="system_id,system_code",$where=null, $reset=false)
	{
		static $enums;
		$eid = $fields.'|'.(is_array($where) ?http_build_query($where) :$where);
		if (!isset($enums[$eid]) || $reset) {
			$enum = Yii::app()->db->createCommand()
				->select($fields)->from('billing__systems')->where($where)
				->queryAll(false);
			$enums[$eid] = CHtml::listData($enum, 0, 1);
		}
		return $enums[$eid];
	}

	public function select($fields="*",$where=null)
	{
		$recs = Yii::app()->db->createCommand()
			->select($fields)->from('billing__systems')->where($where)
			->queryAll();
		
		$sel = array();
		foreach($recs as $r) $sel[$r['system_code']] = $r;
		return $sel;
	}
}