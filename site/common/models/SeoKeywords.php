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
        return 'seo_keywords';
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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

    public function GetSummaryTable()
    {
        $keywords = SeoKeywords::model()->findAll();
        $stats = SeoStats::model()->findAll();

        foreach ($stats as $stat) {

        }
    }

    public function GetSummStats()
    {
        $sum = 0;
        foreach ($this->seoStats as $stat) {
            $sum += $stat->value;
        }

        return $sum;
    }

    public function GetAverageStats(){
        return round($this->GetSummStats()/12);
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
    public function cmp_fun($a, $b){
        if ($a->GetSummStats() == $b->GetSummStats()) {
            return 0;
        }
        return ($a->GetSummStats() < $b->GetSummStats()) ? 1 : -1;
    }
}