<?php

/**
 * This is the model class for table "sites__pages_visits".
 *
 * The followings are the available columns in table 'sites__pages_visits':
 * @property string $id
 * @property integer $site_id
 * @property string $page_id
 * @property string $year
 * @property integer $first_page
 * @property string $sum
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
 *
 * The followings are the available model relations:
 * @property SeoSite $site
 * @property SitePage $page
 */
class SitePageVisit extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SitePageVisit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getDbConnection(){
        return Yii::app()->db_seo;
    }

    public function tableName(){
        return 'sites__pages_visits';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_id, page_id, year', 'required'),
			array('site_id, first_page, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12', 'numerical', 'integerOnly'=>true),
			array('page_id, sum', 'length', 'max'=>10),
			array('year', 'length', 'max'=>3000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, site_id, page_id, year, first_page, sum, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12', 'safe', 'on'=>'search'),
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
			'site' => array(self::BELONGS_TO, 'SeoSite', 'site_id'),
			'page' => array(self::BELONGS_TO, 'SitePage', 'page_id'),
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
			'page_id' => 'Page',
			'year' => 'Year',
			'first_page' => 'First Page',
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
		$criteria->compare('page_id',$this->page_id,true);
		$criteria->compare('year',$this->year,true);
		$criteria->compare('first_page',$this->first_page);
		$criteria->compare('sum',$this->sum,true);
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave()
    {
        $this->sum = $this->m1 + $this->m2 + $this->m3 + $this->m4 + $this->m5 + $this->m6 + $this->m7 + $this->m8 +
            $this->m9 + $this->m10 + $this->m12 + $this->m11;
        return parent::beforeSave();
    }

    public function SaveOrUpdate($month)
    {
        $model = self::model()->findByAttributes(array(
            'page_id' => $this->page_id,
            'year' => $this->year,
            'site_id' => $this->site_id,
            'first_page' => $this->first_page
        ));

        if (isset($model)) {
            $model->setAttribute('m' . $month, $this->getAttribute('m' . $month));
            $model->save();
        } else
            if (!$this->save()){
                var_dump($this->getErrors());
                Yii::app()->end();
            }
    }
}