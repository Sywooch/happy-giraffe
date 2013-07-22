<?php

/**
 * This is the model class for table "seo_keywords".
 *
 * The followings are the available columns in table 'seo_keywords':
 * @property integer $id
 * @property string $name
 * @property integer $wordstat
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property SiteKeywordVisit[] $seoStats
 * @property KeywordGroup[] $group
 * @property KeywordsBlacklist $blacklist
 * @property TempKeyword $tempKeyword
 */
class Keyword extends CActiveRecord
{
    const STATUS_UNDEFINED = 0;
    const STATUS_GOOD = 1;
    const STATUS_HIDE = 2;
    const STATUS_BAD_STRICT_WORDSTAT = 3;

    public $btns;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
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
        return 'keywords.keywords';
    }

    public function getDbConnection()
    {
        return Yii::app()->db_keywords;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 120),
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
            'tempKeyword' => array(self::HAS_ONE, 'TempKeyword', 'keyword_id'),
            'blacklist' => array(self::HAS_ONE, 'KeywordsBlacklist', 'keyword_id'),
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

    public function findSimilarCount($name)
    {
        $allSearch = Yii::app()->search
            ->select('*')
            ->from('keywords')
            ->where(' ' . $name . ' ')
            ->limit(0, 500000)
            ->searchRaw();
        return count($allSearch['matches']);
    }

    public function findSimilarIds($name)
    {
        $allSearch = Yii::app()->search
            ->select('*')
            ->from('keywords')
            ->where(' ' . $name . ' ')
            ->limit(0, 500000)
            ->searchRaw();
        return $allSearch['matches'];
    }

    public function getChildKeywords($num)
    {
        $criteria = new CDbCriteria;

        if (!empty($this->name)) {
            if (strpos($this->name, '/') !== false)
                $this->name = str_replace('/', ' ', $this->name);

            $allSearch = Yii::app()->search
                ->select('*')
                ->from('keywords')
                ->where(' ' . $this->name . ' ')
                ->limit(0, $num)
                ->searchRaw();
            $ids = array();

            $blacklist = Yii::app()->db_seo->createCommand('select keyword_id from ' . KeywordsBlacklist::model()->tableName())->queryColumn();
            foreach ($allSearch['matches'] as $key => $m) {
                if (!in_array($key, $blacklist))
                    $ids [] = $key;
            }

            if (!empty($ids))
                $criteria->compare('t.id', $ids);
            else
                $criteria->compare('t.id', 0);
        }
        $criteria->order = 'wordstat desc';

        return self::model()->findAll($criteria);
    }

    /**
     * Возвращает ключевое слово по его тексту. Если такого слова нет, создает его
     * @static
     * @param string $word ключевое слово
     * @return Keyword
     */
    public static function GetKeyword($word)
    {
        $word = WordstatQueryModify::prepareForSave($word);

        $model = self::model()->findByAttributes(array('name' => $word));
        if ($model !== null)
            return $model;

        $model = new Keyword();
        $model->name = $word;
        try {
            $model->save();
        } catch (Exception $e) {
            //значит кейворд создан в промежуток времени между запросами - повторим запрос
            $model = self::model()->findByAttributes(array('name' => $word));
        }

        //добавляем на простой парсинг
//        if (isset($model->id))
//            WordstatParsingTask::getInstance()->addSimpleTask($model->id);

        return $model;
    }

    /**
     * @return bool
     */
    public function hasOpenedTask()
    {
        if (!empty($this->tempKeyword) && $this->tempKeyword->owner_id != Yii::app()->user->id)
            return true;

        foreach ($this->group as $group) {
            if (!empty($group->page))
                return false;

            if ($group->taskCount > 0)
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
        if (isset($this->blacklist->keyword_id))
            return 'hidden';
        elseif ($this->used()) $class = 'on-site'; elseif ($this->inBuffer()) $class = 'in-buffer'; elseif ($this->hasOpenedTask()) $class = 'in-work';

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
        if (empty($this->wordstat))
            return 0;
        if ($this->wordstat > 10000)
            return 1;
        if ($this->wordstat >= 1500)
            return 2;
        if ($this->wordstat >= 500)
            return 3;
        return 4;
    }

    public function getRoundFrequency()
    {
        if (empty($this->wordstat))
            return '';

        if ($this->wordstat > 1000)
            return round($this->wordstat / 1000, 1);

        if ($this->wordstat > 100)
            return round($this->wordstat / 1000, 2);

        return round($this->wordstat / 1000, 3);
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
            return 'wordstat > 10000';
        if ($freq == 2)
            return 'wordstat <= 10000 AND wordstat > 1500';
        if ($freq == 3)
            return 'wordstat <= 1500 AND wordstat > 500';
        if ($freq == 4)
            return 'wordstat < 500';

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
                return ''; elseif ($this->hasOpenedTask())
                return ''; else
                return '<input type="hidden" value="' . $this->id . '">
                <a href="" class="icon-add" onclick="SeoKeywords.Select(this, ' . (int)$short . ');return false;"></a>
                <a href="" class="icon-hat" data-id="' . $this->id . '" onclick="SeoKeywords.Hide(this);return false;"></a>';

        }
        if ($this->inBuffer()) {
            if ($this->tempKeyword->owner_id == Yii::app()->user->id)
                return 'в буфере <input type="hidden" value="' . $this->id . '"><a href="" class="icon-remove" onclick="SeoKeywords.CancelSelect(this, ' . (int)$short . ');return false;"></a>';
        } elseif ($this->used())
            return 'на сайте'; elseif ($this->hasOpenedTask())
            return 'в работе'; else
            return '<input type="hidden" value="' . $this->id . '">
            <a href="" class="icon-add" onclick="SeoKeywords.Select(this, ' . (int)$short . ');return false;"></a>
            <a href="" class="icon-hat" data-id="' . $this->id . '" onclick="SeoKeywords.Hide(this);return false;"></a>';

        return '';
    }

    public function getKeywordAndSimilarArticles($section = 1)
    {
        $res = $this->name;
        if ($this->hasOpenedTask())
            return $res;
        if ($this->used()) {
            if (empty($this->group))
                return $res;

            foreach ($this->group as $group_)
                $group = $group_;
            if (empty($group->page))
                return $res;

            return $res . CHtml::link('', $group->page->url, array(
                'target' => '_blank',
                'class' => 'icon-article'
            )) . '<a onclick="SeoModule.unbindKeyword(this, ' . $this->id . ')" class="icon-link active" href="javascript:;"></a>';
        }

        $res .= $this->getSimilarArticlesHtml();
        return $res;
    }

    public function getSimilarArticlesHtml()
    {
        Yii::import('site.seo.modules.writing.components.*');
        $models = SimilarArticles::getArticles($this->id);
        if (!empty($models)) {
            $res = '<a href="javascript:;" class="icon-links-trigger" onclick="$(this).toggleClass(\'triggered\').next().toggle();"></a><div class="links" style="display:none;">';
            foreach ($models as $model) {
                $res .= CHtml::link($model->title, 'http://www.happy-giraffe.ru' . $model->url, array('target' => '_blank')) . '  ';
                $res .= CHtml::link('', 'javascript:;', array(
                    'onclick' => 'SeoModule.bindKeywordToArticle(' . $this->id . ', ' . $model->id . ', "' . get_class($model) . '", this);',
                    'class' => 'icon-link'
                )) . '<br>';
            }
            $res .= CHtml::link('', 'javascript:;', array(
                'onclick' => '$(this).next().toggle()',
                'class' => 'icon-link'
            )) . '<div style="display:none;">
                          <input type="text" size="40">
                          <a href="javascript:;" class="btn-green-small" onclick="SeoModule.bindKeyword(this, ' . $this->id . ');">Ok</a>
                      </div></div>';
        } else {
            $res = CHtml::link('', 'javascript:;', array(
                'onclick' => '$(this).next().toggle()',
                'class' => 'icon-link'
            )) . '<div style="display:none;">
                          <input type="text" size="40">
                          <a href="javascript:;" class="btn-green-small" onclick="SeoModule.bindKeyword(this, ' . $this->id . ');">Ok</a>
                      </div>';
        }

        return $res;
    }

    /**
     * Сохраняем статус ключевого слова
     *
     * @param $status
     */
    public function saveStatus($status)
    {
        $this->status = $status;
        $this->update(array('status', 'wordstat'));
    }
}