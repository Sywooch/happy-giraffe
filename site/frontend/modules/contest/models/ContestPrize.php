<?php

/**
 * This is the model class for table "{{contest_prize}}".
 *
 * The followings are the available columns in table '{{contest_prize}}':
 * @property string $prize_id
 * @property string $prize_contest_id
 * @property integer $prize_place
 * @property string $prize_item_id
 * @property string $prize_text
 *
 * rel
 * @property Contest $contest
 */
class ContestPrize extends CActiveRecord
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
		return '{{club_contest_prize}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prize_place, prize_item_id', 'required'),
			array('prize_place', 'numerical', 'integerOnly'=>true),
			array('prize_contest_id, prize_item_id', 'length', 'max'=>10),
			array('prize_text', 'safe'),

			array('prize_place','placeExist'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prize_id, prize_contest_id, prize_place, prize_item_id, prize_text', 'safe', 'on'=>'search'),
		);
	}

	public function placeExist($attribute,$attributes)
	{
		if($this->prize_place)
		{
			$where = 'prize_contest_id=:prize_contest_id AND prize_place=:prize_place';
			$params = array(
				':prize_contest_id'=>$this->prize_contest_id,
				'prize_place'=>$this->prize_place,
			);
			if(!$this->getIsNewRecord())
			{
				$where .= ' AND prize_id<>:prize_id';
				$params[':prize_id'] = $this->prize_id;
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
			'contest' => array(self::BELONGS_TO, 'Contest', 'prize_contest_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'prize_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'prize_id' => 'Prize',
			'prize_contest_id' => 'Prize Contest',
			'prize_place' => 'Prize Place',
			'prize_item_id' => 'Prize Item',
			'prize_text' => 'Prize Text',
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

		$criteria->compare('prize_id',$this->prize_id,true);
		$criteria->compare('prize_contest_id',$this->prize_contest_id,true);
		$criteria->compare('prize_place',$this->prize_place);
		$criteria->compare('prize_item_id',$this->prize_item_id,true);
		$criteria->compare('prize_text',$this->prize_text,true);
		if(!isset($_GET[__CLASS__.'_sort']))
			$criteria->order = 'prize_place';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	

	
}