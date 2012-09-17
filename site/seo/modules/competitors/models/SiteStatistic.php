<?php

/**
 * This is the model class for table "sites__statistics".
 *
 * The followings are the available columns in table 'sites__statistics':
 * @property string $id
 * @property integer $site_id
 * @property integer $visit_name_id
 * @property integer $year
 * @property integer $month
 * @property integer $day
 * @property integer $value
 */
class SiteStatistic extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SiteStatistic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getDbConnection(){
        return Yii::app()->db_seo;
    }

    public function tableName(){
        return 'sites__statistics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_id, visit_name_id, year, month, value', 'required'),
			array('site_id, visit_name_id, year, month, day', 'numerical', 'integerOnly'=>true),
            array('value', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, site_id, visit_name_id, year, month, value', 'safe', 'on'=>'search'),
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
			'visit_name_id' => 'Visit Name',
			'year' => 'Year',
			'month' => 'Month',
			'value' => 'Value',
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
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('visit_name_id',$this->visit_name_id);
		$criteria->compare('year',$this->year);
		$criteria->compare('month',$this->month);
		$criteria->compare('value',$this->value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function SaveOrUpdate()
    {
        $model = self::model()->findByAttributes(array(
            'visit_name_id'=>$this->visit_name_id,
            'year'=>$this->year,
            'month'=>$this->month,
            'day'=>$this->day,
            'site_id'=>$this->site_id
        ));

        if (isset($model)){
            echo 'Пропущена статистика '.$this->visit_name_id.' - '.$model->value.' - '.$this->value.'<br>';
        }else
            if (!$this->save()){
                var_dump($this->getErrors());
                Yii::app()->end();
            }
    }
}