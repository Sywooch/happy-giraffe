<?php

/**
 * This is the model class for table "queries".
 *
 * The followings are the available columns in table 'queries':
 * @property string $id
 * @property string $keyword_id
 * @property string $visits
 * @property string $page_views
 * @property double $denial
 * @property double $depth
 * @property integer $visit_time
 * @property integer $date
 *
 * The followings are the available model relations:
 * @property QuerySearchEngine[] $searchEngines
 * @property Keyword $keyword
 */
class Query extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Query the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'queries';
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
            array('keyword_id, visits, page_views, denial, depth, visit_time', 'required'),
            array('visit_time', 'numerical', 'integerOnly' => true),
            array('denial, depth', 'numerical'),
            array('keyword_id', 'length', 'max' => 1024),
            array('visits, page_views', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, keyword_id, visits, page_views, denial, depth, visit_time', 'safe', 'on' => 'search'),
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
            'searchEngines' => array(self::HAS_MANY, 'QuerySearchEngine', 'query_id'),
            'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'keyword_id' => 'Поисковый запрос',
            'visits' => 'Визитов',
            'page_views' => 'Просмотров',
            'denial' => 'Отказов',
            'depth' => 'Глубина',
            'visit_time' => 'Время посещения, сек',
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
        $criteria->compare('keyword_id', $this->keyword_id);
        $criteria->compare('visits', $this->visits);
        $criteria->compare('page_views', $this->page_views);
        $criteria->compare('parsing', $this->parsing);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 50),
        ));
    }

    public function getVisits($keyword_id, $se, $week, $year)
    {
        $model = self::model()->findByAttributes(compact('keyword_id', 'week', 'year'));
        if ($model !== null) {
            $se = QuerySearchEngine::model()->findByAttributes(array(
                'query_id' => $model->id,
                'se_id' => $se,
            ));
            if ($se !== null)
                return $se->visits;
        }

        return 0;
    }
}