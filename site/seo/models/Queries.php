<?php

/**
 * This is the model class for table "queries".
 *
 * The followings are the available columns in table 'queries':
 * @property string $id
 * @property string $phrase
 * @property string $visits
 * @property string $page_views
 * @property double $denial
 * @property double $depth
 * @property integer $visit_time
 * @property integer $parsing
 *
 * The followings are the available model relations:
 * @property QueriesPages[] $queriesPages
 * @property QueriesSearchEngines[] $queriesSearchEngines
 */
class Queries extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Queries the static model class
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
		return 'queries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('phrase, visits, page_views, denial, depth, visit_time', 'required'),
			array('visit_time, parsing', 'numerical', 'integerOnly'=>true),
			array('denial, depth', 'numerical'),
			array('phrase', 'length', 'max'=>1024),
			array('visits, page_views', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, phrase, visits, page_views, denial, depth, visit_time, parsing', 'safe', 'on'=>'search'),
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
			'queriesPages' => array(self::HAS_MANY, 'QueriesPages', 'query_id'),
			'queriesSearchEngines' => array(self::HAS_MANY, 'QueriesSearchEngines', 'query_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'phrase' => 'Phrase',
			'visits' => 'Visits',
			'page_views' => 'Page Views',
			'denial' => 'Denial',
			'depth' => 'Depth',
			'visit_time' => 'Visit Time',
			'parsing' => 'Parsing',
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
		$criteria->compare('phrase',$this->phrase,true);
		$criteria->compare('visits',$this->visits,true);
		$criteria->compare('page_views',$this->page_views,true);
		$criteria->compare('denial',$this->denial);
		$criteria->compare('depth',$this->depth);
		$criteria->compare('visit_time',$this->visit_time);
		$criteria->compare('parsing',$this->parsing);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}