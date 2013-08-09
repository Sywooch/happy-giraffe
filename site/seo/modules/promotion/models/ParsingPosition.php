<?php

/**
 * This is the model class for table "parsing_positions".
 *
 * The followings are the available columns in table 'parsing_positions':
 * @property integer $keyword_id
 * @property integer $active
 * @property integer $yandex
 * @property integer $google
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 */
class ParsingPosition extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ParsingPosition the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return CDbConnection database connection
     */
    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'parsing_positions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('keyword_id', 'numerical', 'integerOnly' => true),
            array('keyword_id, active, yandex, google', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
        );
    }

    /**
     * Собираем ключевые слова из трафика Веселого Жирафа за последний месяц, импортированного из метрики
     */
    public static function collectTrafficKeywords()
    {
        $offset = 0;
        $keywords = 1;
        while (!empty($keywords)) {
            $keywords = Yii::app()->db_seo->createCommand()
                ->select('keyword_id')
                ->from('giraffe_last_month_traffic')
                ->offset($offset)
                ->limit(10000)
                ->order('keyword_id')
                ->queryColumn();

            foreach ($keywords as $keyword)
                self::addKeyword($keyword);

            $offset += 10000;
        }
    }

    /**
     * Собираем ключевые слова из тех, по которым написаны статьи
     */
    public static function collectPagesKeywords()
    {
        //берем кейворды по которым заходили за последние 4 недели
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = Page::model()->with('keywordGroup', 'keywordGroup.keywords')->findAll($criteria);

            foreach ($models as $model)
                if (!empty($model->keywordGroup))
                    foreach ($model->keywordGroup->keywords as $keyword)
                        self::addKeyword($keyword->id);

            $criteria->offset += 100;
        }
    }

    /**
     * Собираем ключевые слова конкурентов за текущий год
     */
    public static function collectCompetitorsKeywords()
    {
        $offset = 0;
        $keywords = 1;
        while (!empty($keywords)) {
            $keywords = Yii::app()->db_seo->createCommand()
                ->select('distinct(keyword_id)')
                ->from('sites__keywords_visits')
                ->where('year = :year', array(':year' => 2013))
                ->offset($offset)
                ->limit(10000)
                ->order('keyword_id')
                ->queryColumn();

            foreach ($keywords as $keyword)
                self::addKeyword($keyword);

            $offset += 10000;
        }
    }

    /**
     * Добавляем ключевое слово на сбор позиций
     * @param int $keyword_id
     */
    public static function addKeyword($keyword_id)
    {
        if (self::model()->findByPk($keyword_id) === null) {
            $p = new ParsingPosition;
            $p->keyword_id = $keyword_id;
            $p->save();
        }
    }
}