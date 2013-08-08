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
    const FILTER_ALL = 1;
    const FILTER_NO_TRAFFIC = 2;
    const FILTER_NO_TRAFFIC_HAVE_ARTICLES = 3;
    const FILTER_HAVE_TRAFFIC_NO_ARTICLES = 4;

    public $all;
    public $key_name;
    public $popular;
    public $popularIcon;
    public $freq;
    public $our_traffic;
    public $pos_yandex;
    public $pos_google;

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
            array('site_id, keyword_id, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, sum, key_name, year, freq, popular', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
            'site' => array(self::BELONGS_TO, 'Site', 'site_id'),
            'traffic' => array(self::HAS_ONE, 'GiraffeLastMonthTraffic', 'keyword_id'),
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
     * Поиск по статистике конкурентов
     * @param int $type тип фильтрации
     * @return CActiveDataProvider
     */
    public function search($type)
    {
        $criteria = $this->getMainCriteria($type);

//        if (!empty($this->freq)) {
//            $condition = Keyword::getFreqCondition($this->freq);
//            if (!in_array('keyword', $criteria->with))
//                $criteria->with [] = 'keyword';
//
//            if (!empty($criteria->condition)) {
//                $criteria->condition .= ' AND ' . $condition;
//            } else
//                $criteria->condition = $condition;
//        }
        $criteria->with = array('keyword', 'site.group as site_group', 'keyword.group', 'keyword.group.page', 'keyword.tempKeyword', 'keyword.blacklist');
        $total_count = self::model()->count($criteria);
        $criteria->with = array('keyword', 'site.group as site_group', 'keyword.group', 'keyword.group.page', 'keyword.group.taskCount', 'keyword.tempKeyword', 'keyword.blacklist', 'site');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'totalItemCount' => $total_count,
            'pagination' => array('pageSize' => 50),
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

    /**
     * Возвращает критерий для выбора статистики без учета частотности слов
     * @param $type
     * @return CDbCriteria
     */
    public function getMainCriteria($type)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('keyword');
        if (!empty($this->site_id))
            $criteria->addCondition('site_id = ' . $this->site_id);
        if (!empty($_GET['group_id']))
            $criteria->addCondition('site_group.id = ' . $_GET['group_id']);

        $criteria->compare('year', $this->year);
        $criteria->together = true;

        if (!empty($this->key_name))
            $criteria = $this->findByKeyword($criteria);
        else{
            switch($type){
                case self::FILTER_HAVE_TRAFFIC_NO_ARTICLES:
                    $criteria->addCondition('group.id IS NULL AND tempKeyword.keyword_id IS NULL');
                    $criteria->with = array('keyword', 'keyword.group', 'keyword.tempKeyword', 'keyword.blacklist');
                    break;
                case self::FILTER_NO_TRAFFIC:

                    break;
                case self::FILTER_NO_TRAFFIC_HAVE_ARTICLES:
                    $criteria->addCondition('group.id IS NULL AND tempKeyword.keyword_id IS NULL');
                    $criteria->with = array('keyword', 'keyword.group', 'keyword.tempKeyword', 'keyword.blacklist');
                    break;

                    break;
            }
        }

        return $criteria;
    }



    /**
     * @param CDbCriteria $criteria
     * @return CDbCriteria;
     */
    public function findByKeyword($criteria)
    {
        if ($this->temp_ids === null)
            $this->temp_ids = Keyword::findSiteIdsByNameWithSphinx($this->key_name);

        if (empty($this->temp_ids))
            $criteria->addCondition('keyword.id = 0');
        else
            $criteria->addCondition('keyword.id IN (' . implode(',', $this->temp_ids) . ')');

        return $criteria;
    }

    /**
     * Среднее кол-во переходов за месяц
     * @return float
     */
    public function GetAverageStats()
    {
        return round($this->sum / 12);
    }

    /**
     * Сохранение кол-ва переходов при парсинге статистики
     *
     * @param int $site_id
     * @param int $keyword_id
     * @param int $month
     * @param int $year
     * @param int $value
     */
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