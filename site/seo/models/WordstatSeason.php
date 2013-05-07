<?php

/**
 * This is the model class for table "wordstat_season".
 *
 * The followings are the available columns in table 'wordstat_season':
 * @property integer $keyword_id
 * @property integer $month
 * @property integer $year
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 */
class WordstatSeason extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WordstatSeason the static model class
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
		return 'wordstat_season';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keyword_id, month, year, value', 'required'),
			array('keyword_id, month, year', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('keyword_id, month, year, value', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
		);
	}

    public static function add($keyword_id, $year, $month, $value){
        $model = new WordstatSeason();
        $model->keyword_id = $keyword_id;
        $model->year = $year;
        $model->month = $month;
        $model->value = $value;
        $model->save();
    }
}