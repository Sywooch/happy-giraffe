<?php

/**
 * This is the model class for table "keywords_strict_wordstat".
 *
 * The followings are the available columns in table 'keywords_strict_wordstat':
 * @property integer $keyword_id
 * @property integer $wordstat
 * @property integer $strict_wordstat
 */
class KeywordStrictWordstat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KeywordStrictWordstat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_keywords;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'keywords_strict_wordstat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keyword_id, wordstat, strict_wordstat', 'required'),
			array('keyword_id, wordstat, strict_wordstat', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('keyword_id, wordstat, strict_wordstat', 'safe', 'on'=>'search'),
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
			'keyword_id' => 'Keyword',
			'wordstat' => 'Wordstat',
			'strict_wordstat' => 'Strict Wordstat',
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

		$criteria->compare('keyword_id',$this->keyword_id);
		$criteria->compare('wordstat',$this->wordstat);
		$criteria->compare('strict_wordstat',$this->strict_wordstat);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}