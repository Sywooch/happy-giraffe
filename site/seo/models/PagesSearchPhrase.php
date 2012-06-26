<?php

/**
 * This is the model class for table "pages_search_phrases".
 *
 * The followings are the available columns in table 'pages_search_phrases':
 * @property string $id
 * @property string $page_id
 * @property integer $keyword_id
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 * @property Page $page
 * @property SearchPhrasePosition[] $positions
 * @property SearchPhraseVisit[] $visits
 */
class PagesSearchPhrase extends HActiveRecord
{
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
        return 'happy_giraffe_seo.pages_search_phrases';
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
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, page_id, keyword_id', 'safe', 'on' => 'search'),
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
            'page' => array(self::BELONGS_TO, 'Page', 'page_id'),
            'positions' => array(self::HAS_MANY, 'SearchPhrasePosition', 'search_phrase_id', 'order' => 'date desc'),
            'visits' => array(self::HAS_MANY, 'SearchPhraseVisit', 'search_phrase_id'),
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
        $criteria = new CDbCriteria;
        $criteria->compare('keyword_id', $this->keyword_id);
        $criteria->compare('week', $week);
        $criteria->compare('year', $year);
        $models = Query::model()->findAll($criteria);

        foreach ($models as $model) {
            foreach ($model->searchEngines as $searchEngine)
                if ($searchEngine->se_id == $se)
                    return $searchEngine->visits;
        }

        return 0;
    }

    public function getSimilarKeywords()
    {
        $keywords = $this->keyword->getChildKeywords(10);

        return $keywords;
    }

    public function getLinksCount()
    {
        return InnerLink::model()->countByAttributes(array(
            'phrase_id' => $this->id
        ));
    }

    public function getPositionView($se)
    {
        $se_positions = $this->getPositionsArray($se);

        if (empty($se_positions))
            return '';

        if (count($se_positions) == 1)
            return $this->getPosition($se);

        $last = $se_positions[0];
        $prev = $se_positions[1];

        $i = 2;
        while($prev->position == $last->position){
            if (!isset($se_positions[$i]))
                break;
            $prev = $se_positions[$i];
            $i++;
        }

        if ($last->position < $prev->position){
            return $last->position.' <i class="icon-up"></i> '.'<a onmouseover="SeoLinking.showPositions(this, '.$se.', '.$this->id.')" href="javascript:;">'.$prev->position.'</a>';
        }
        if ($last->position > $prev->position){
            return $last->position.' <i class="icon-down"></i> '.'<a onmouseover="SeoLinking.showPositions(this, '.$se.', '.$this->id.')" href="javascript:;">'.$prev->position.'</a>';
        }

        return $last->position;
    }

    /**
     * @param int $se
     * @return SearchPhrasePosition[]
     */
    public function getPositionsArray($se)
    {
        $se_positions = array();
        foreach ($this->positions as $position)
            if ($position->se_id == $se)
                $se_positions[] = $position;
        return $se_positions;
    }
}