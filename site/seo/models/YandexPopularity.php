<?php

/**
 * This is the model class for table "yandex_popularity".
 *
 * The followings are the available columns in table 'yandex_popularity':
 * @property integer $keyword_id
 * @property string $date
 * @property integer $value
 * @property integer $parsed
 * @property integer $theme
 * @property integer $season_parsed
 * @property integer $season_value
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 */
class YandexPopularity extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return YandexPopularity the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'keywords.yandex_popularity';
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
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('keyword_id', 'required'),
            array('value, parsed, theme', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('keyword_id, date, value', 'safe', 'on' => 'search'),
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'keyword_id' => 'Keyword',
            'date' => 'Date',
            'value' => 'Value',
        );
    }

    public function beforeSave()
    {
        $this->date = date("Y-m-d");

        return parent::beforeSave();
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

        $criteria->compare('keyword_id', $this->keyword_id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('value', $this->value);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function addValue($keyword_id, $value, $theme)
    {
        $yaPop = YandexPopularity::model()->findByPk($keyword_id);
        if ($yaPop !== null) {
            $yaPop->value = $value;
            try {
                $yaPop->theme = $theme;
                $yaPop->save();
            } catch (Exception $e) {

            }
        } else {
            $yaPop = new YandexPopularity;
            $yaPop->keyword_id = $keyword_id;
            $yaPop->theme = $theme;
            $yaPop->value = $value;
            try {
                $yaPop->save();
            } catch (Exception $e) {

            }
        }
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
        if ($this->value > 10000)
            return 1;
        if ($this->value >= 1500)
            return 2;
        if ($this->value >= 500)
            return 3;
        return 4;
    }
}