<?php

/**
 * This is the model class for table "seo_keywords".
 *
 * The followings are the available columns in table 'seo_keywords':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property KeyStats[] $seoStats
 * @property KeywordGroup[] $group
 * @property PastuhovYandexPopularity $pastuhovYandex
 * @property KeywordBlacklist $keywordBlacklist
 * @property RamblerPopularity $ramblerPopularity
 * @property YandexPopularity $yandex
 */
class Keywords extends HActiveRecord
{
    public $btns;

    /**
     * Returns the static model of the specified AR class.
     * @return Keywords the static model class
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
        return 'happy_giraffe_seo.keywords';
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
            'seoStats' => array(self::HAS_MANY, 'KeyStats', 'keyword_id'),
            'group' => array(self::MANY_MANY, 'KeywordGroup', 'keyword_group_keywords(keyword_id, group_id)'),
            'pastuhovYandex' => array(self::HAS_ONE, 'PastuhovYandexPopularity', 'keyword_id'),
            'yandex' => array(self::HAS_ONE, 'YandexPopularity', 'keyword_id'),
            'ramblerPopularity' => array(self::HAS_ONE, 'RamblerPopularity', 'keyword_id'),
            'tempKeyword' => array(self::HAS_ONE, 'TempKeywords', 'keyword_id'),
            'keywordBlacklist' => array(self::HAS_ONE, 'KeywordBlacklist', 'keyword_id'),
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
        $criteria = new CDbCriteria;
        //$criteria->compare('t.id', $this->id);
        if (!empty($this->name)) {
            $allSearch = Yii::app()->search
                ->select('*')
                ->from('keywords')
                ->where(' ' . $this->name . ' ')
                ->limit(0, 100000)
                ->searchRaw();
            $ids = array();
            foreach ($allSearch['matches'] as $key => $m) {
                $ids [] = $key;
                break;
            }
            if (!empty($ids))
                $criteria->compare('t.id', $ids);
            else
                $criteria->compare('t.id', null);
        }
        $criteria->with = array('group', 'pastuhovYandex', 'tempKeyword');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
        ));
    }

    /**
     * @static
     * @param string $word
     * @return Keywords
     * @throws CHttpException
     */
    public static function GetKeyword($word)
    {
        $word = trim($word);
        $model = self::model()->findByAttributes(array('name' => $word));
        if ($model !== null)
            return $model;

        $model = new Keywords();
        $model->name = $word;
        if (!$model->save())
            throw new CHttpException(404, 'Кейворд не сохранен. ' . $word);

        return $model;
    }

    public function hasOpenedTask()
    {
        foreach ($this->group as $group) {
            if (!empty($group->articleKeywords))
                return false;

            if ($group->newTaskCount > 0)
                return true;
        }

        return false;
    }

    public function used()
    {
        foreach ($this->group as $group) {
            if (!empty($group->articleKeywords))
                return true;
        }
        return false;
    }

    public function inBuffer()
    {
        if (!empty($this->tempKeyword))
            return true;

        return false;
    }

    public function getClass()
    {
        $class = '';
        if ($this->used()) $class = 'on-site';
        elseif ($this->inBuffer()) $class = 'in-buffer';
        elseif ($this->hasOpenedTask()) $class = 'in-work';

        return $class;
    }

    public function getData()
    {
        $res = '';
        if (!empty($this->seoStats))
            foreach ($this->seoStats as $seoStat)
                $res .= $seoStat->sum . ', ';

        return $res;
    }

    public function getStats($site_id)
    {
        foreach ($this->seoStats as $stats) {
            if ($stats->site_id == $site_id)
                return round($stats->sum / 12);
        }

        return 0;
    }

    public function getFreqIcon()
    {
        $freq = $this->getFreq();
        if ($freq != 0)
            return '<i class="icon-freq-' . $freq . '"></i>';
        return '';
    }

    public function getFreq()
    {
        if (!isset($this->yandex))
            return 0;
        if ($this->yandex->value > 10000)
            return 1;
        if ($this->yandex->value >= 1500)
            return 2;
        if ($this->yandex->value >= 500)
            return 3;
        return 4;
    }

    /**
     * @param int $freq
     * @return string
     */
    public static function getFreqCondition($freq)
    {
        if ($freq == 1)
            return 'yandex.value > 10000';
        if ($freq == 2)
            return 'yandex.value <= 10000 AND yandex.value > 1500';
        if ($freq == 3)
            return 'yandex.value <= 1500 AND yandex.value > 500';
        if ($freq == 4)
            return 'yandex.value < 500';

        return '';
    }

    /*public static function findByNameWithSphinx($name)
    {
        $allSearch = Yii::app()->search
            ->select('*')
            ->from('keywords2')
            ->where($name)
            ->limit(0, 1)
            ->searchRaw();

        if (!empty($allSearch['matches'])){
            $id = 0;
            foreach ($allSearch['matches'] as $key => $m) {
                $id = $key;
                break;
            }
            return self::model()->findByPk($id);
        }

        return null;
    }*/

    public function findKeywords($name)
    {
        $allSearch = Yii::app()->search
            ->select('*')
            ->from('keywords')
            ->where(' ' . $name . ' ')
            ->limit(0, 10000)
            ->searchRaw();
        $ids = array();
        $blacklist = Yii::app()->db->createCommand('select keyword_id from ' . KeywordBlacklist::model()->tableName())->queryColumn();

        foreach ($allSearch['matches'] as $key => $m) {
            if (!in_array($key, $blacklist))
                $ids [] = $key;
        }

        if (!empty($ids)) {
            $criteria = new CDbCriteria;
            $criteria->compare('t.id', $ids);
            $criteria->with = array('group', 'group.newTaskCount', 'group.articleKeywords', 'seoStats', 'pastuhovYandex', 'ramblerPopularity');
            $criteria->order = 'pastuhovYandex.value desc';
            $models = Keywords::model()->findAll($criteria);
        } else
            $models = array();

        return $models;
    }

    public function getFreqCount($models)
    {
        $result = array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0);
        foreach ($models as $model) {
            $result [$model->freq]++;
        }

        return $result;
    }

    public function getButtons($short = false)
    {
        if ($short) {
            if ($this->inBuffer())
                return '<input type="hidden" value="' . $this->id . '"><a href="" class="icon-remove" onclick="SeoKeywords.CancelSelect(this);return false;"></a>';
            elseif ($this->used())
                return '';
            elseif ($this->hasOpenedTask())
                return '';
            else
                return '<input type="hidden" value="' . $this->id . '"><a href="" class="icon-add" onclick="SeoKeywords.Select(this);return false;"></a>';

        }
        if ($this->inBuffer())
            return 'в буфере <input type="hidden" value="' . $this->id . '"><a href="" class="icon-remove" onclick="SeoKeywords.CancelSelect(this);return false;"></a>';
        elseif ($this->used())
            return 'на сайте';
        elseif ($this->hasOpenedTask())
            return 'в работе';
        else
            return '<input type="hidden" value="' . $this->id . '">
            <a href="" class="icon-add" onclick="SeoKeywords.Select(this);return false;"></a>
            <a href="" class="icon-hat" onclick="SeoKeywords.Hide(this);return false;"></a>';
    }
}