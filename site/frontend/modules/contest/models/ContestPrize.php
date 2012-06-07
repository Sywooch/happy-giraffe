<?php

/**
 * This is the model class for table "{{contest_prize}}".
 *
 * The followings are the available columns in table '{{contest_prize}}':
 * @property string $id
 * @property string $contest_id
 * @property integer $place
 * @property string $item_id
 * @property string $text
 *
 * rel
 * @property Contest $contest
 */
class ContestPrize extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ContestPrize the static model class
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
		return 'contest__prizes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('place, item_id', 'required'),
			array('place', 'numerical', 'integerOnly'=>true),
			array('contest_id, item_id', 'length', 'max'=>10),
			array('text', 'safe'),

			array('place','placeExist'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, contest_id, place, item_id, text', 'safe', 'on'=>'search'),
		);
	}

	public function placeExist($attribute,$attributes)
	{
		if($this->place)
		{
			$where = 'contest_id=:contest_id AND place=:place';
			$params = array(
				':contest_id'=>$this->contest_id,
				'prize_place'=>$this->prize_place,
			);
			if(!$this->getIsNewRecord())
			{
				$where .= ' AND id<>:id';
				$params[':id'] = $this->id;
			}

			$place = Yii::app()->db->createCommand()
				->select('prize_id')
				->from($this->tableName())
				->limit(1)
				->where($where, $params)
				->queryScalar();

			if($place)
				$this->addError('prize_place', Yii::t('ContestModule.models', 'Prize exists'));

		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'contest' => array(self::BELONGS_TO, 'Contest', 'contest_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Prize',
			'contest_id' => 'Prize Contest',
			'prize_place' => 'Prize Place',
			'item_id' => 'Prize Item',
			'text' => 'Prize Text',
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

		$criteria->compare('id',$this->prize_id,true);
		$criteria->compare('contest_id',$this->contest_id,true);
		$criteria->compare('prize_place',$this->prize_place);
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('text',$this->text,true);
		if(!isset($_GET[__CLASS__.'_sort']))
			$criteria->order = 'prize_place';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	

	
}