<?php

/**
 * This is the model class for table "keywords_statuses".
 *
 * The followings are the available columns in table 'keywords_statuses':
 * @property integer $keyword_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 */
class KeywordStatus extends CActiveRecord
{
    const STATUS_UNDEFINED = 0;
    const STATUS_GOOD = 1;
    const STATUS_HIDE = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KeywordStatus the static model class
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
        return Yii::app()->db_keywords;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'keywords_statuses';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('keyword_id, status', 'required'),
            array('keyword_id, status', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('keyword_id, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'keyword' => array(self::BELONGS_TO, 'Keywords', 'keyword_id'),
        );
    }

    /**
     * Сохраняем статус ключевого слова
     *
     * @param $keyword_id
     * @param $status
     */
    public static function saveStatus($keyword_id, $status)
    {
        $model = KeywordStatus::model()->findByPk($keyword_id);
        if ($model === null) {
            $model = new KeywordStatus;
            $model->keyword_id = $keyword_id;
            $model->status = $status;
            try {
                $model->save();
            } catch (Exception $err) {
            }
        } elseif ($status != $model->status) {
            $model->status = $status;
            $model->save();
        }
    }
}