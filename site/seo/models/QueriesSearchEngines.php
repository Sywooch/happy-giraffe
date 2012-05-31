<?php

/**
 * This is the model class for table "queries_search_engines".
 *
 * The followings are the available columns in table 'queries_search_engines':
 * @property string $id
 * @property string $query_id
 * @property string $se_id
 * @property string $se_page
 * @property string $se_url
 *
 * The followings are the available model relations:
 * @property Queries $query
 */
class QueriesSearchEngines extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QueriesSearchEngines the static model class
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
		return 'queries_search_engines';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('query_id', 'required'),
			array('query_id, se_id, se_page', 'length', 'max'=>10),
			array('se_url', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, query_id, se_id, se_page, se_url', 'safe', 'on'=>'search'),
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
			'query' => array(self::BELONGS_TO, 'Queries', 'query_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'query_id' => 'Query',
			'se_id' => 'Se',
			'se_page' => 'Se Page',
			'se_url' => 'Se Url',
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
		$criteria->compare('query_id',$this->query_id,true);
		$criteria->compare('se_id',$this->se_id,true);
		$criteria->compare('se_page',$this->se_page,true);
		$criteria->compare('se_url',$this->se_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}