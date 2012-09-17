<?php

/**
 * This is the model class for table "sites__browser_visits".
 *
 * The followings are the available columns in table 'sites__browser_visits':
 * @property string $id
 * @property integer $browser_id
 * @property integer $site_id
 * @property integer $year
 * @property integer $month
 * @property integer $value
 *
 * The followings are the available model relations:
 * @property SiteBrowser $browser
 */
class SiteBrowserVisit extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SiteBrowserVisit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getDbConnection(){
        return Yii::app()->db_seo;
    }

    public function tableName(){
        return 'sites__browser_visits';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('browser_id, site_id, year, month, value', 'required'),
			array('browser_id, site_id, year, month', 'numerical', 'integerOnly'=>true),
			array('id, browser_id, site_id, year, month, value', 'safe', 'on'=>'search'),
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
			'browser' => array(self::BELONGS_TO, 'SiteBrowser', 'browser_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'browser_id' => 'Browser',
			'site_id' => 'Site',
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
		$criteria->compare('browser_id',$this->browser_id);
		$criteria->compare('site_id',$this->site_id);
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
            'browser_id'=>$this->browser_id,
            'year'=>$this->year,
            'month'=>$this->month,
            'site_id'=>$this->site_id
        ));

        if (isset($model)){
            echo 'Пропущена статистика '.$this->browser->name.' - '.$model->value.' - '.$this->value.'<br>';
        }else
            if (!$this->save()){
                var_dump($this->getErrors());
                Yii::app()->end();
            }

    }
}