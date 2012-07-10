<?php

/**
 * This is the model class for table "seo_keywords".
 *
 * The followings are the available columns in table 'seo_keywords':
 * @property integer $id
 * @property string $name
 * @property string $our
 *
 * The followings are the available model relations:
 * @property KeyStats[] $seoStats
 * @property KeywordGroup[] $group
 * @property PastuhovYandexPopularity $pastuhovYandex
 * @property KeywordBlacklist $keywordBlacklist
 * @property YandexPopularity $yandex
 * @property TempKeyword $tempKeyword
 */
class Keyword extends HActiveRecord
{
    public $btns;

    /**
     * Returns the static model of the specified AR class.
     * @return Keyword the static model class
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
        return array(
            array('name', 'length', 'max' => 1024),
            array('id, name, our', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'seoStats' => array(self::HAS_MANY, 'SiteKeywordVisit', 'keyword_id'),
            'group' => array(self::MANY_MANY, 'KeywordGroup', 'keyword_group_keywords(keyword_id, group_id)'),
            'pastuhovYandex' => array(self::HAS_ONE, 'PastuhovYandexPopularity', 'keyword_id'),
            'yandex' => array(self::HAS_ONE, 'YandexPopularity', 'keyword_id'),
            'tempKeyword' => array(self::HAS_ONE, 'TempKeyword', 'keyword_id'),
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

        if (!empty($this->name)) {
            $allSearch = Yii::app()->search
                ->select('*')
                ->from('keywords')
                ->where(' ' . $this->name . ' ')
                ->limit(0, 50000)
                ->searchRaw();
            $ids = array();

            $blacklist = Yii::app()->db->createCommand('select keyword_id from ' . KeywordBlacklist::model()->tableName())->queryColumn();
            foreach ($allSearch['matches'] as $key => $m) {
                if (!in_array($key, $blacklist))
                    $ids [] = $key;
            }

            if (!empty($ids))
                $criteria->compare('t.id', $ids);
            else
                $criteria->compare('t.id', 0);
        }
        $criteria->with = array('yandex');
        $criteria->order = 'yandex.value desc';

        return new CActiveDataProvider('Keyword', array(
            'criteria' => $criteria,
        ));
    }

    public function getChildKeywords($num)
    {
        $criteria = new CDbCriteria;

        if (!empty($this->name)) {
            $allSearch = Yii::app()->search
                ->select('*')
                ->from('keywords')
                ->where(' ' . $this->name . ' ')
                ->limit(0, $num)
                ->searchRaw();
            $ids = array();

            $blacklist = Yii::app()->db->createCommand('select keyword_id from ' . KeywordBlacklist::model()->tableName())->queryColumn();
            foreach ($allSearch['matches'] as $key => $m) {
                if (!in_array($key, $blacklist))
                    $ids [] = $key;
            }

            if (!empty($ids))
                $criteria->compare('t.id', $ids);
            else
                $criteria->compare('t.id', 0);
        }
        $criteria->with = array('yandex');
        $criteria->order = 'yandex.value desc';

        return self::model()->findAll($criteria);
    }

    /**
     * @static
     * @param string $word
     * @return Keyword
     * @throws CHttpException
     */
    public static function GetKeyword($word)
    {
        $word = trim($word);
        $model = self::model()->findByAttributes(array('name' => $word));
        if ($model !== null)
            return $model;

        $model = new Keyword();
        $model->name = $word;
        if (!$model->save())
            throw new CHttpException(404, 'Кейворд не сохранен. ' . $word);

        return $model;
    }

    /**
     * @return bool
     */
    public function hasOpenedTask()
    {
        if (!empty($this->tempKeyword))
            return true;

        foreach ($this->group as $group) {
            if (!empty($group->page))
                return false;

            if ($group->newTaskCount > 0)
                return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function used()
    {
        foreach ($this->group as $group) {
            if (!empty($group->page))
                return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function inBuffer()
    {
        if (!empty($this->tempKeyword) && $this->tempKeyword->owner_id == Yii::app()->user->id)
            return true;

        return false;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        $class = '';
        if ($this->used()) $class = 'on-site';
        elseif ($this->inBuffer()) $class = 'in-buffer';
        elseif ($this->hasOpenedTask()) $class = 'in-work';

        return $class;
    }

    /**
     * @param $site_id
     * @return int
     */
    public function getStats($site_id)
    {
        foreach ($this->seoStats as $stats) {
            if ($stats->site_id == $site_id)
                return $stats->GetAverageStats();
        }

        return 0;
    }

    /**
     * @return string
     */
    public function getFreqIcon()
    {
        $freq = $this->getFreq();
        if ($freq != 0)
            return '<i class="icon-freq-' . $freq . '"></i>';
        return '';
    }

    /**
     * @return int
     */
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

    public function getFrequency(){
        if (isset($this->yandex))
            return $this->yandex->value;
        return '';
    }

    public function getRoundFrequency()
    {
        if (empty($this->yandex))
            return '';

        if ($this->yandex->value > 1000)
            return round($this->yandex->value/1000,1);

        if ($this->yandex->value > 100)
            return round($this->yandex->value/1000,2);

        return round($this->yandex->value/1000,3);
    }

    /**
     * @param CDbCriteria $criteria
     * @return array
     */
    public function getFreqCount($criteria)
    {
        $counts = array(0 => Keyword::model()->count($criteria));

        for ($i = 1; $i < 5; $i++) {
            $criteria2 = clone $criteria;
            $counts[$i] = Keyword::model()->count($criteria2->addCondition(Keyword::getFreqCondition($i)));
        }
        return $counts;
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

    /**
     * @static
     * @param string $name
     * @return array
     */
    public static function findSiteIdsByNameWithSphinx($name)
    {
        $allSearch = Yii::app()->search
            ->select('*')
            ->from('sitesKeywords')
            ->where(' ' . $name . ' ')
            ->limit(0, 100000)
            ->searchRaw();
        $ids = array();

        foreach ($allSearch['matches'] as $key => $m) {
            $ids [] = $key;
        }

        return $ids;
    }

    public function getButtons($short = false)
    {
        if ($short) {
            if ($this->inBuffer()) {
                if ($this->tempKeyword->owner_id == Yii::app()->user->id)
                    return '<input type="hidden" value="' . $this->id . '"><a href="" class="icon-remove" onclick="SeoKeywords.CancelSelect(this, ' . (int)$short . ');return false;"></a>';
            } elseif ($this->used())
                return '';
            elseif ($this->hasOpenedTask())
                return '';
            else
                return '<input type="hidden" value="' . $this->id . '"><a href="" class="icon-add" onclick="SeoKeywords.Select(this, ' . (int)$short . ');return false;"></a>';

        }
        if ($this->inBuffer()) {
            if ($this->tempKeyword->owner_id == Yii::app()->user->id)
                return 'в буфере <input type="hidden" value="' . $this->id . '"><a href="" class="icon-remove" onclick="SeoKeywords.CancelSelect(this, ' . (int)$short . ');return false;"></a>';
        } elseif ($this->used())
            return 'на сайте';
        elseif ($this->hasOpenedTask())
            return 'в работе';
        else
            return '<input type="hidden" value="' . $this->id . '">
            <a href="" class="icon-add" onclick="SeoKeywords.Select(this, ' . (int)$short . ');return false;"></a>
            <a href="" class="icon-hat" onclick="SeoKeywords.Hide(this);return false;"></a>';

        return '';
    }

    public function getKeywordAndSimilarArticles()
    {
        $res = $this->name;
        if ($this->hasOpenedTask())
            return $res;
        if ($this->used()) {
            if (empty($this->group))
                return $res;

            foreach ($this->group as $group_) {
                $group = $group_;
            }
            if (empty($group->page))
                return $res;

            return $res . CHtml::link('', $group->page->url, array(
                'target' => '_blank',
                'class' => 'icon-article'
            ));
        }

        $models = $this->getSimilarArticles();
        if (!empty($models)) {
            $res .= '<a href="javascript:;" class="icon-links-trigger" onclick="$(this).toggleClass(\'triggered\').next().toggle();"></a><div class="links" style="display:none;">';
            foreach ($models as $model){
                $res .= CHtml::link($model->title, 'http://www.happy-giraffe.ru' . $model->url, array('target' => '_blank')).'  ';
                $res .= CHtml::link('', 'javascript:;', array(
                    'onclick' => 'SeoModule.bindKeywordToArticle('.$this->id.', '.$model->id.', this);',
                    'class'=>'icon-link'
                )) . '<br>';
            }
            $res .= '</div>';
        }

        return $res;
    }

    public function getSimilarArticles()
    {
        Yii::import('site.frontend.extensions.*');
        $this->name = str_replace('/', '', $this->name);
        $allSearch = Yii::app()->search
            ->select('*')
            ->from('communityTextTitle')
            ->where(' ' . CHtml::encode($this->name) . ' ')
            ->limit(0, 5)
            ->searchRaw();
        if (empty($allSearch['matches']))
            return null;

        $ids = array();

        $i = 0;
        foreach ($allSearch['matches'] as $key => $m) {
            $ids [] = $key;
            $i++;
            if ($i > 5)
                break;
        }

        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $ids);
        $criteria->limit = 5;

        $models = CommunityContent::model()->resetScope()->findAll($criteria);
        return $models;
    }
}