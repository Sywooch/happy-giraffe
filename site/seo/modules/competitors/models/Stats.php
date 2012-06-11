<?php

/**
 * This is the model class for table "stats".
 *
 * The followings are the available columns in table 'stats':
 * @property integer $id
 * @property integer $keyword_id
 * @property integer $site_id
 * @property integer $year
 * @property integer $month
 * @property integer $value
 *
 * The followings are the available model relations:
 * @property Keywords $keyword
 */
class Stats extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Stats the static model class
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
        return 'happy_giraffe_seo.baby_stats__stats';
    }

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('keyword_id, year, month', 'required'),
            array('keyword_id, site_id, year, month, value', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, keyword_id, site_id, year, month, value', 'safe', 'on'=>'search'),
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
            'keyword' => array(self::BELONGS_TO, 'Keywords', 'keyword_id'),
            'site' => array(self::BELONGS_TO, 'Site', 'site_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'keyword_id' => 'Keyword',
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
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('keyword_id',$this->keyword_id);
        $criteria->compare('site_id',$this->site_id);
        $criteria->compare('year',$this->year);
        $criteria->compare('month',$this->month);
        $criteria->compare('value',$this->value);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }


}