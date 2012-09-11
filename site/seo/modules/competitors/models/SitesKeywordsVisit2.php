<?php

/**
 * This is the model class for table "sites__keywords_visits2".
 *
 * The followings are the available columns in table 'sites__keywords_visits2':
 * @property integer $id
 * @property integer $site_id
 * @property string $keyword
 * @property integer $sum
 * @property integer $m1
 * @property integer $m2
 * @property integer $m3
 * @property integer $m4
 * @property integer $m5
 * @property integer $m6
 * @property integer $m7
 * @property integer $m8
 * @property integer $m9
 * @property integer $m10
 * @property integer $m11
 * @property integer $m12
 * @property integer $year
 */
class SitesKeywordsVisit2 extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SitesKeywordsVisit2 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getDbConnection(){
        return Yii::app()->db_seo;
    }

    public function tableName(){
        return 'sites__keywords_visits2';
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_id', 'required'),
			array('site_id, sum, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, year', 'numerical', 'integerOnly'=>true),
			array('keyword', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('site_id, keyword, sum, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, year', 'safe'),
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
			'id' => 'ID',
			'site_id' => 'Site',
			'keyword' => 'Keyword',
			'sum' => 'Sum',
			'm1' => 'M1',
			'm2' => 'M2',
			'm3' => 'M3',
			'm4' => 'M4',
			'm5' => 'M5',
			'm6' => 'M6',
			'm7' => 'M7',
			'm8' => 'M8',
			'm9' => 'M9',
			'm10' => 'M10',
			'm11' => 'M11',
			'm12' => 'M12',
			'year' => 'Year',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->compare('sum',$this->sum);
		$criteria->compare('m1',$this->m1);
		$criteria->compare('m2',$this->m2);
		$criteria->compare('m3',$this->m3);
		$criteria->compare('m4',$this->m4);
		$criteria->compare('m5',$this->m5);
		$criteria->compare('m6',$this->m6);
		$criteria->compare('m7',$this->m7);
		$criteria->compare('m8',$this->m8);
		$criteria->compare('m9',$this->m9);
		$criteria->compare('m10',$this->m10);
		$criteria->compare('m11',$this->m11);
		$criteria->compare('m12',$this->m12);
		$criteria->compare('year',$this->year);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}