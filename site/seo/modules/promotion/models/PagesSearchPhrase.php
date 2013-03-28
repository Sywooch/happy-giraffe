<?php

/**
 * This is the model class for table "pages_search_phrases".
 *
 * The followings are the available columns in table 'pages_search_phrases':
 * @property string $id
 * @property string $page_id
 * @property integer $keyword_id
 * @property integer $inner_links_count
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 * @property Page $page
 * @property SearchPhrasePosition[] $positions
 * @property InnerLink[] $links
 * @property int $linksCount
 */
class PagesSearchPhrase extends HActiveRecord
{
    const SORT_BY_POSITION = 1;
    const SORT_BY_FREQ = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PagesSearchPhrase the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    public function tableName()
    {
        return 'pages_search_phrases';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('page_id, keyword_id', 'required'),
            array('keyword_id', 'numerical', 'integerOnly' => true),
            array('page_id', 'length', 'max' => 11),
            array('id, page_id, keyword_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
            'page' => array(self::BELONGS_TO, 'Page', 'page_id'),
            'positions' => array(self::HAS_MANY, 'SearchPhrasePosition', 'search_phrase_id', 'order' => 'date desc'),
            'lastPosition' => array(self::HAS_ONE, 'SearchPhrasePosition', 'search_phrase_id', 'order' => 'lastPosition.date desc'),
            'links' => array(self::HAS_MANY, 'InnerLink', 'phrase_id'),
            'linksCount' => array(self::STAT, 'InnerLink', 'phrase_id'),
            'skip' => array(self::HAS_ONE, 'ILSkip', 'phrase_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'page_id' => 'Page',
            'keyword_id' => 'Keyword',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('page_id', $this->page_id, true);
        $criteria->compare('keyword_id', $this->keyword_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 30),
        ));
    }

    public function getPosition($se)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('search_phrase_id', $this->id);
        $criteria->compare('se_id', $se);
        $criteria->order = 'date desc';

        $model = SearchPhrasePosition::model()->find($criteria);
        if ($model !== null)
            return $model->position;

        return '';
    }

    public function getVisits($se, $period)
    {
        if ($period == 1) {
            return $this->getWeekVisits($se, date('W') - 1, date('Y'));
        } else {
            $week = date('W') - 1;
            $year = date('Y');

            $visits = 0;
            for ($i = 0; $i < 4; $i++) {
                $visits += $this->getWeekVisits($se, $week, $year);

                if ($week == 1) {
                    $week = 52;
                    $year--;
                } else
                    $week--;
            }
            return $visits;
        }
    }

    public function getWeekVisits($se, $week, $year)
    {
        return 0;
    }

    public function getSimilarKeywords()
    {
        $keywords = $this->keyword->getChildKeywords(10);
        foreach ($keywords as $key => $keyword)
            if ($keyword->id == $this->keyword->id)
                unset($keywords[$key]);
        array_unshift($keywords, $this->keyword);

        return $keywords;
    }

    public function getPositionView($se)
    {
        $se_positions = $this->getPositionsArray($se);

        if (empty($se_positions))
            return '';

        if (count($se_positions) == 1)
            return $this->showPosition(PromotionHelper::model()->getPosition($this->id, $se));

        $last = $se_positions[0];
        $prev = $se_positions[1];

        $i = 2;
        while ($prev->position == $last->position) {
            if (!isset($se_positions[$i]))
                break;
            $prev = $se_positions[$i];
            $i++;
        }

        if ($last->position < $prev->position) {
            return $this->showPosition($last->position) . ' <i class="icon-up"></i> ' . '<a onmouseover="SeoLinking.showPositions(this, ' . $se . ', ' . $this->id . ')" href="javascript:;">' . $prev->position . '</a>';
        }
        if ($last->position > $prev->position) {
            return $this->showPosition($last->position) . ' <i class="icon-down"></i> ' . '<a onmouseover="SeoLinking.showPositions(this, ' . $se . ', ' . $this->id . ')" href="javascript:;">' . $prev->position . '</a>';
        }

        return $this->showPosition($last->position);
    }

    public function showPosition($position)
    {
        if ($position >= 1000)
            return '> 100';

        return $position;
    }

    /**
     * @static
     * @return PagesSearchPhrase
     */
/*    public static function getActualPhrase()
    {
        if (SeoUserAttributes::getAttribute('se_tab') == 1)
            return self::getYandexPhrase();
        else
            return self::getGooglePhrase();
    }

    public static function getGooglePhrase()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, `skip`.`phrase_id` as skips';
        $criteria->with = array(
            'keyword' => array('select' => 'name'),
            'keyword.yandex' => array(
                'select' => 'value',
                'condition' => 'value >= :wordstat_min',
                'params' => array(':wordstat_min' => SeoUserAttributes::getAttribute('wordstat_min'))
            ),
            'skip',
            'links'
        );

        $criteria->together = true;
        $criteria->condition = 'skip.phrase_id IS NULL
        AND google_traffic >= :google_visits_min
        AND last_yandex_position > 3
        AND inner_links_count < 1';

        $criteria->params = array(
            ':google_visits_min' => SeoUserAttributes::getAttribute('google_visits_min')
        );

        TimeLogger::model()->startTimer('get google phrase');
        $model = PagesSearchPhrase::model()->find($criteria);
        TimeLogger::model()->endTimer();

        return $model;
    }

    public static function getYandexPhrase()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, `skip`.`phrase_id` as skips';
        $criteria->with = array(
            'keyword' => array('select' => 'name'),
            'keyword.yandex' => array(
                'select' => 'value',
                'condition' => 'value >= :wordstat_min',
                'params' => array(':wordstat_min' => SeoUserAttributes::getAttribute('wordstat_min'))
            ),
            'skip',
        );
        $criteria->condition = 'inner_links_count < 1';
        $criteria->together = true;

        if (SeoUserAttributes::getAttribute('yandex_sort') == self::SORT_BY_POSITION)
            $criteria->order = 'last_yandex_position asc';
        else
            $criteria->order = 'yandex.value desc';
        $criteria->condition .= ' AND skip.phrase_id IS NULL AND last_yandex_position > :min_yandex_position
                                AND last_yandex_position < :max_yandex_position';

        $criteria->params = array(
            ':min_yandex_position' => SeoUserAttributes::getAttribute('min_yandex_position'),
            ':max_yandex_position' => SeoUserAttributes::getAttribute('max_yandex_position'),
        );

        if (SeoUserAttributes::getAttribute('yandex_traffic'))
            $criteria->condition .= ' AND yandex_traffic > 0';

        TimeLogger::model()->startTimer('get yandex phrase');
        $model = PagesSearchPhrase::model()->find($criteria);
        TimeLogger::model()->endTimer();


        return $model;
    }*/

    /**
     * @param int $se
     * @return SearchPhrasePosition[]
     */
    public function getPositionsArray($se)
    {
        $value = array();
        foreach ($this->positions as $position) {
            if ($position->se_id == $se)
                $value[] = $position;
            if (count($value) >= 10)
                break;
        }
        return $value;
    }

    public function getAverageVisits()
    {
        $sum = 0;
        $models = array();
        foreach ($models as $model)
            $sum += $model->visits;

        if (count($models) == 0)
            return 0;

        return round($sum / (count($models)));
    }

    public function calculateLinksCount()
    {
        $this->inner_links_count = InnerLink::model()->count('phrase_id = '.$this->id);
        $this->update(array('inner_links_count'));
    }
}