<?php

/**
 * This is the model class for table "seo__key_stats".
 *
 * The followings are the available columns in table 'seo__key_stats':
 * @property integer $id
 * @property integer $site_id
 * @property integer $keyword_id
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
 * @property integer $sum
 * @property integer $year
 *
 * The followings are the available model relations:
 * @property SeoKeywords $keyword
 * @property SeoSite $site
 */
class SeoKeyStats extends HActiveRecord
{
    public $all;
    public $avarage;
    public $key_name;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SeoKeyStats the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'seo__key_stats';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, keyword_id, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, keyword_id, sum, year', 'required'),
            array('site_id, keyword_id, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, sum, year', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, site_id, keyword_id, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, sum, key_name, year', 'safe'),
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
            'keyword' => array(self::BELONGS_TO, 'SeoKeywords', 'keyword_id'),
            'site' => array(self::BELONGS_TO, 'SeoSite', 'site_id'),
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
            'keyword_id' => 'Keyword',
            'all' => 'Всего',
            'avarage' => 'Среднее',
            'm1' => 'Янв',
            'm2' => 'Фев',
            'm3' => 'Мар',
            'm4' => 'Апр',
            'm5' => 'Май',
            'm6' => 'Июн',
            'm7' => 'Июл',
            'm8' => 'Авг',
            'm9' => 'Сен',
            'm10' => 'Окт',
            'mll' => 'Ноя',
            'ml2' => 'Дек',
            'sum' => 'Всего',
            'year'=>'Год'
        );
    }

    public function beforeSave()
    {
        $this->sum = $this->m1 + $this->m2 + $this->m3 + $this->m4 + $this->m5 + $this->m6 + $this->m7 + $this->m8 +
            $this->m9 + $this->m10 + $this->m11 + $this->m12;

        if ($this->sum == 0)
            return false;

        return parent::beforeSave();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        if (!empty($_GET['SeoKeyStats']["key_name"]))
            $this->key_name = $_GET['SeoKeyStats']["key_name"];

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('year', $this->year);
        $criteria->compare('t2.name', $this->key_name, true);
        $criteria->join = ' LEFT JOIN '.SeoKeywords::model()->tableName().' as t2 ON keyword_id = t2.id ';
        $criteria->with = array('keyword');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
            'sort' => array(
                'attributes' => array(
                    'sum'=>array('default'=>'desc'),
                    'm1'=>array('default'=>'desc'),
                    'm2'=>array('default'=>'desc'),
                    'm3'=>array('default'=>'desc'),
                    'm4'=>array('default'=>'desc'),
                    'm5'=>array('default'=>'desc'),
                    'm6'=>array('default'=>'desc'),
                    'm7'=>array('default'=>'desc'),
                    'm8'=>array('default'=>'desc'),
                    'm9'=>array('default'=>'desc'),
                    'm10'=>array('default'=>'desc'),
                    'm11'=>array('default'=>'desc'),
                    'm12'=>array('default'=>'desc'),
                ),
                'defaultOrder' => 'sum desc',
            ),
        ));
    }

    public function GetAverageStats()
    {
        return round($this->sum / 12);
    }
}