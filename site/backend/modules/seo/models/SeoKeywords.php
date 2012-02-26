<?php

/**
 * This is the model class for table "seo_keywords".
 *
 * The followings are the available columns in table 'seo_keywords':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property SeoStats[] $seoStats
 */
class SeoKeywords extends CActiveRecord
{
    public $all;
    public $avarage;
    public $m1;
    public $m2;
    public $m3;
    public $m4;
    public $m5;
    public $m6;
    public $m7;
    public $m8;
    public $m9;
    public $m10;
    public $m11;
    public $m12;

    /**
     * Returns the static model of the specified AR class.
     * @return SeoKeywords the static model class
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
        return 'seo__keywords';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'length', 'max' => 1024),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name', 'safe', 'on' => 'search'),
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
            'seoStats' => array(self::HAS_MANY, 'SeoStats', 'keyword_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
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
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->select = array('t.id', 't.name', 'SUM(m.value)', 'SUM(t1.value)', 'SUM(t2.value)'
        , 'SUM(t3.value)', 'SUM(t4.value)', 'SUM(t5.value)', 'SUM(t6.value)', 'SUM(t7.value)', 'SUM(t8.value)'
        , 'SUM(t9.value)', 'SUM(t10.value)', 'SUM(t11.value)', 'SUM(t12.value)');
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->join = ' LEFT JOIN seo__stats as m ON t.id = m.keyword_id
        LEFT JOIN seo__stats as t1 ON t.id = t1.keyword_id AND t1.month = 1
        LEFT JOIN seo__stats as t2 ON t.id = t2.keyword_id AND t2.month = 2
        LEFT JOIN seo__stats as t3 ON t.id = t3.keyword_id AND t3.month = 3
        LEFT JOIN seo__stats as t4 ON t.id = t4.keyword_id AND t4.month = 4
        LEFT JOIN seo__stats as t5 ON t.id = t5.keyword_id AND t5.month = 5
        LEFT JOIN seo__stats as t6 ON t.id = t6.keyword_id AND t6.month = 6
        LEFT JOIN seo__stats as t7 ON t.id = t7.keyword_id AND t7.month = 7
        LEFT JOIN seo__stats as t8 ON t.id = t8.keyword_id AND t8.month = 8
        LEFT JOIN seo__stats as t9 ON t.id = t9.keyword_id AND t9.month = 9
        LEFT JOIN seo__stats as t10 ON t.id = t10.keyword_id AND t10.month = 10
        LEFT JOIN seo__stats as t11 ON t.id = t11.keyword_id AND t11.month = 11
        LEFT JOIN seo__stats as t12 ON t.id = t12.keyword_id AND t12.month = 12
        ';
        $criteria->group = 'm.keyword_id';

        $sort = new CSort();
        $sort->attributes = array(
            'all' => array(
                'asc' => 'SUM(t2.value) ASC',
                'desc' => 'SUM(t2.value) DESC',
            ),
            'avarage' => array(
                'asc' => 'SUM(t2.value) ASC',
                'desc' => 'SUM(t2.value) DESC',
            ),
            'm1' => array(
                'asc' => 'SUM(t1.value) ASC',
                'desc' => 'SUM(t1.value) DESC',
            ),
            'm2' => array(
                'asc' => 'SUM(t2.value) ASC',
                'desc' => 'SUM(t2.value) DESC',
            ),
            'm3' => array(
                'asc' => 'SUM(t3.value) ASC',
                'desc' => 'SUM(t3.value) DESC',
            ),
            'm4' => array(
                'asc' => 'SUM(t4.value) ASC',
                'desc' => 'SUM(t4.value) DESC',
            ),
            'm5' => array(
                'asc' => 'SUM(t5.value) ASC',
                'desc' => 'SUM(t5.value) DESC',
            ),
            'm6' => array(
                'asc' => 'SUM(t6.value) ASC',
                'desc' => 'SUM(t6.value) DESC',
            ),
            'm7' => array(
                'asc' => 'SUM(t7.value) ASC',
                'desc' => 'SUM(t7.value) DESC',
            ),
            'm8' => array(
                'asc' => 'SUM(t8.value) ASC',
                'desc' => 'SUM(t8.value) DESC',
            ),
            'm9' => array(
                'asc' => 'SUM(t9.value) ASC',
                'desc' => 'SUM(t9.value) DESC',
            ),
            'm10' => array(
                'asc' => 'SUM(t10.value) ASC',
                'desc' => 'SUM(t10.value) DESC',
            ),
            'm11' => array(
                'asc' => 'SUM(t11.value) ASC',
                'desc' => 'SUM(t11.value) DESC',
            ),
            'm12' => array(
                'asc' => 'SUM(t12.value) ASC',
                'desc' => 'SUM(t12.value) DESC',
            ),
            '*',
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
            'sort' => $sort
        ));
    }

    /**
     * @static
     * @param string $word
     * @return SeoKeywords
     * @throws CHttpException
     */
    public static function GetKeyword($word)
    {
        $word = trim($word);
        $model = self::model()->findByAttributes(array(
            'name' => $word,
        ));
        if (isset($model))
            return $model;

        $model = new SeoKeywords();
        $model->name = $word;
        if (!$model->save())
            throw new CHttpException(404, 'Кейворд не сохранен. ' . $word);

        return $model;
    }

    public function GetSummStats()
    {
        $sum = 0;
        foreach ($this->seoStats as $stat) {
            $sum += $stat->value;
        }

        return $sum;
    }

    public function GetAverageStats()
    {
        return round($this->GetSummStats() / 12);
    }

    public function GetMonthStats($month)
    {
        foreach ($this->seoStats as $stat) {
            if ($stat->month == $month)
                return $stat->value;
        }
        return 0;
    }

    /**
     * @param SeoKeywords $a
     * @param SeoKeywords $b
     * @return int
     */
    public function cmp_fun($a, $b)
    {
        if ($a->GetSummStats() == $b->GetSummStats()) {
            return 0;
        }
        return ($a->GetSummStats() < $b->GetSummStats()) ? 1 : -1;
    }
}