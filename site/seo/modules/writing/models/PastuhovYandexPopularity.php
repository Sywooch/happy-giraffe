<?php

/**
 * This is the model class for table "pastuhov_yandex_popularity".
 *
 * The followings are the available columns in table 'pastuhov_yandex_popularity':
 * @property integer $keyword_id
 * @property integer $value
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 */
class PastuhovYandexPopularity extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PastuhovYandexPopularity the static model class
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
		return 'pastuhov_yandex_popularity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keyword_id, value', 'required'),
			array('keyword_id, value', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('keyword_id, value', 'safe', 'on'=>'search'),
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
			'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
		);
	}

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'keyword_id' => 'Keyword',
			'value' => 'Y popularity',
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
		$criteria->compare('value',$this->value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}