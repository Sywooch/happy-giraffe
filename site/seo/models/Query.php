<?php

/**
 * This is the model class for table "queries".
 *
 * The followings are the available columns in table 'queries':
 * @property string $id
 * @property string $phrase
 * @property string $visits
 * @property string $page_views
 * @property double $denial
 * @property double $depth
 * @property integer $visit_time
 * @property integer $parsing
 * @property integer $yandex_parsed
 * @property integer $google_parsed
 *
 * The followings are the available model relations:
 * @property QueryPage[] $pages
 * @property QuerySearchEngine[] $searchEngines
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
        return 'happy_giraffe_seo.queries';
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
            array('phrase, visits, page_views, denial, depth, visit_time', 'required'),
            array('visit_time, parsing, google_parsed, yandex_parsed', 'numerical', 'integerOnly' => true),
            array('denial, depth', 'numerical'),
            array('phrase', 'length', 'max' => 1024),
            array('visits, page_views', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, phrase, visits, page_views, denial, depth, visit_time, parsing', 'safe', 'on' => 'search'),
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
            'pages' => array(self::HAS_MANY, 'QueryPage', 'query_id'),
            'searchEngines' => array(self::HAS_MANY, 'QuerySearchEngine', 'query_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'phrase' => 'Поисковый запрос',
            'visits' => 'Визитов',
            'page_views' => 'Просмотров',
            'denial' => 'Отказов',
            'depth' => 'Глубина',
            'visit_time' => 'Время посещения, сек',
            'parsing' => 'Parsing',
            'activePages' => 'Страницы в выдаче',
            'yandexPos' => 'Позиция в Yandex',
            'googlePos' => 'Позиция в Google',
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
        $criteria->compare('phrase', $this->phrase, true);
        $criteria->compare('visits', $this->visits, true);
        $criteria->compare('page_views', $this->page_views, true);
        $criteria->compare('denial', $this->denial);
        $criteria->compare('depth', $this->depth);
        $criteria->compare('visit_time', $this->visit_time);
        $criteria->compare('parsing', $this->parsing);
        $criteria->with = 'pages';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 50),
        ));
    }

    public function getActivePages()
    {
        $res = '';
        foreach ($this->pages as $page) {
            $res .= CHtml::link($page->page_url, $page->page_url) . '<br>';
        }

        return $res;
    }

    public function getYandexPos()
    {
        $res = '';
        foreach ($this->pages as $page) {
            $res .= $page->yandex_position . '<br>';
        }

        return $res;
    }

    public function getGooglePos()
    {
        $res = '';
        foreach ($this->pages as $page) {
            $res .= $page->google_position . '<br>';
        }

        return $res;
    }
}