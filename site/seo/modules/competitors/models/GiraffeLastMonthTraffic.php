<?php

/**
 * This is the model class for table "giraffe_last_month_traffic".
 *
 * The followings are the available columns in table 'giraffe_last_month_traffic':
 * @property integer $keyword_id
 * @property string $value
 * @property string $active
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 */
class GiraffeLastMonthTraffic extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return GiraffeLastMonthTraffic the static model class
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
        return 'giraffe_last_month_traffic';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('keyword_id, value', 'required'),
            array('keyword_id', 'numerical', 'integerOnly' => true),
            array('value', 'length', 'max' => 11),
            array('keyword_id, value', 'safe', 'on' => 'search'),
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
     * Вычисляет месяцный трафик по всем словам на Веселый Жираф
     */
    public static function calcMonthTraffic()
    {
        $date = date("Y-m-d", strtotime('-31 days'));
        Yii::app()->db_seo->createCommand()->update(self::model()->tableName(), array('active' => 0));

        $keywordIds = 1;
        $offset = 0;
        while (!empty($keywordIds)) {
            $keywordIds = Yii::app()->db_seo->createCommand()
                ->selectDistinct('keyword_id')
                ->from('queries')
                ->where('date > :date', array(':date' => $date))
                ->offset($offset)
                ->limit(10000)
                ->queryColumn();
            echo count($keywordIds) . "\n";

            foreach ($keywordIds as $keyword_id) {
                $month_traffic = Yii::app()->db_seo->createCommand()
                    ->select('sum(visits)')
                    ->from('queries')
                    ->where('date>:date AND keyword_id = :keyword_id', array(
                        ':date' => $date,
                        ':keyword_id' => $keyword_id
                    ))
                    ->queryScalar();

                $exist = Yii::app()->db_seo->createCommand()
                    ->select('keyword_id')
                    ->from(self::model()->tableName())
                    ->where('keyword_id = :keyword_id', array(':keyword_id' => $keyword_id))
                    ->queryScalar();
                if (empty($exist)) {
                    Yii::app()->db_seo->createCommand()->insert(self::model()->tableName(), array(
                        'keyword_id' => $keyword_id,
                        'value' => $month_traffic,
                        'active' => 1
                    ));
                } else {
                    Yii::app()->db_seo->createCommand()->update(self::model()->tableName(), array('active' => 1, 'value' => $month_traffic), 'keyword_id = :keyword_id', array(':keyword_id' => $keyword_id));
                }
            }

            $offset += 10000;
        }

        Yii::app()->db_seo->createCommand()->delete(self::model()->tableName(), 'active=0');
    }
}