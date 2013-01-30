<?php

/**
 * This is the model class for table "yandex_popularity_season".
 *
 * The followings are the available columns in table 'yandex_popularity_season':
 * @property integer $keyword_id
 * @property integer $month
 * @property integer $year
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 */
class YandexPopularitySeason extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return YandexPopularitySeason the static model class
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
        return 'yandex_popularity_season';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('keyword_id, month, year, value', 'required'),
            array('keyword_id, month, year', 'numerical', 'integerOnly' => true),
            array('value', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('keyword_id, month, year, value', 'safe', 'on' => 'search'),
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
        );
    }

    public static function addValue($keyword_id, $month, $year, $value)
    {
        $model = new YandexPopularitySeason;
        $model->keyword_id = $keyword_id;
        $model->month = $month;
        $model->year = $year;
        $model->value = $value;
        try {
            $model->save();
        } catch (Exception $e) {
        }
    }
}