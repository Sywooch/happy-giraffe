<?php

/**
 * This is the model class for table "sites__keywords_visits".
 *
 * The followings are the available columns in table 'sites__keywords_visits':
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
 * @property Keyword $keyword
 * @property Site $site
 */
class SiteKeywordVisit extends HActiveRecord
{
    public $all;
    public $key_name;
    public $popular;
    public $popularIcon;
    public $freq;
    /**
     * @var Site[]
     */
    public $sites_id;

    private $temp_ids = null;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SiteKeywordVisit the static model class
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
        return 'sites__keywords_visits';
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
            array('site_id, keyword_id, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, keyword_id, sum, year', 'required'),
            array('site_id, keyword_id, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, sum, year', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('site_id, keyword_id, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, sum, key_name, year, freq, popular', 'safe'),
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
            'site_id' => 'Site',
            'keyword_id' => 'Keyword',
            'key_name' => 'Ключевое слово',
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
            'year' => 'Год'
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
        $criteria = $this->getCriteriaWithoutFreq();

        if (!empty($this->freq)) {
            $condition = Keyword::getFreqCondition($this->freq);
            if (!in_array('keyword', $criteria->with))
                $criteria->with [] = 'keyword';

            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ' . $condition;
            } else
                $criteria->condition = $condition;
        }

        $full_criteria = clone $criteria;
        $full_criteria->with = array('site');

        return new CActiveDataProvider($this, array(
            'criteria' => $full_criteria,
            'totalItemCount' => self::model()->count($criteria),
            'pagination' => array('pageSize' => 100),
            'sort' => array(
                'attributes' => array(
                    'popular' => array(
                        'asc' => 'wordstat desc',
                    ),
                    'm1' => array('default' => 'desc'),
                    'm2' => array('default' => 'desc'),
                    'm3' => array('default' => 'desc'),
                    'm4' => array('default' => 'desc'),
                    'm5' => array('default' => 'desc'),
                    'm6' => array('default' => 'desc'),
                    'm7' => array('default' => 'desc'),
                    'm8' => array('default' => 'desc'),
                    'm9' => array('default' => 'desc'),
                    'm10' => array('default' => 'desc'),
                    'm11' => array('default' => 'desc'),
                    'm12' => array('default' => 'desc'),
                ),
                'defaultOrder' => 'sum desc',
            ),
        ));
    }

    public function getCriteriaWithoutFreq()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('keyword');

        if (Yii::app()->user->getState('hide_used') == 1) {
            $criteria->condition = 'group.id IS NULL AND ((tempKeyword.keyword_id IS NOT NULL AND tempKeyword.owner_id = ' . Yii::app()->user->id . ') OR tempKeyword.keyword_id IS NULL)';
            $criteria->with = array('keyword', 'keyword.group', 'keyword.tempKeyword', 'keyword.blacklist');
        }

        if (!empty($this->key_name)) {
            if ($this->temp_ids === null)
                $this->temp_ids = Keyword::findSiteIdsByNameWithSphinx($this->key_name);

            if (empty($this->temp_ids))
                $criteria->addCondition('keyword.id = 0');
            else
                $criteria->addCondition('keyword.id IN (' . implode(',', $this->temp_ids) . ')');
        }

        //search by site_id
        if (count($this->sites_id) == 1)
            $criteria->addCondition('site_id = ' . $this->sites_id[0]);
        else
            $criteria->addCondition('site_id IN (' . implode(',', $this->sites_id) . ') ');

        $criteria->compare('year', $this->year);
        $criteria->together = true;

        return $criteria;
    }

    public function getCriteriaWithoutFreqForCounts()
    {
        $criteria = $this->getCriteriaWithoutFreq();

        return $criteria;
    }

    public function GetAverageStats()
    {
        if ($this->year == 2012)
            return round($this->sum / 5);
        return round($this->sum / 12);
    }

    public function getButtons()
    {
        return $this->keyword->getButtons(true);
    }

    public static function SaveValue($site_id, $keyword_id, $month, $year, $value)
    {
        $model = self::model()->findByAttributes(array(
            'keyword_id' => $keyword_id,
            'year' => $year,
            'site_id' => $site_id
        ));

        if ($model !== null) {
            //второй раз и меньше - значит слово в котором есть буква ё
            $old = $model->getAttribute('m' . $month);
            if ($old > $value)
                return;

            $model->setAttribute('m' . $month, $value);
        } else {
            $model = new SiteKeywordVisit();
            $model->site_id = $site_id;
            $model->keyword_id = $keyword_id;
            $model->year = $year;
            $model->setAttribute('m' . $month, $value);
        }

        $model->save();
    }
}