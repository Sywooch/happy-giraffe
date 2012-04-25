<?php

/**
 * This is the model class for table "pregnancy_weight".
 *
 * The followings are the available columns in table 'pregnancy_weight':
 * @property integer $week
 * @property string $w1
 * @property string $w2
 * @property string $w3
 */
class PregnancyWeight extends HActiveRecord
{
    const BMI1 = 19.8;
    const BMI2 = 26;
    const CACHE_ID = 'pregnant_weight';

    /**
     * Returns the static model of the specified AR class.
     * @return PregnancyWeight the static model class
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
        return 'services__pregnancy_weight';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('week, w1, w2, w3', 'required'),
            array('week', 'numerical', 'integerOnly' => true),
            array('w1, w2, w3', 'length', 'max' => 8),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('week, w1, w2, w3', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'week' => 'Неделя',
            'w1' => 'Прибавка в весе (ИМТ < 19,8)',
            'w2' => 'Прибавка в весе (26 < ИМТ < 19,8)',
            'w3' => 'Прибавка в весе (ИМТ > 26)',
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

        $criteria->compare('week', $this->week);
        $criteria->compare('w1', $this->w1, true);
        $criteria->compare('w2', $this->w2, true);
        $criteria->compare('w3', $this->w3, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * @static
     * @param $week int 
     * @param $bmi float body mass index
     * @return float
     */
    public static function GetWeightGainByWeekAndBMI($week, $bmi)
    {
        if ($week % 2 == 0)
            return self::GetWeightGainByEvenWeekAndBMI($week, $bmi);
        else
            return self::GetWeightGainByOddWeekAndBMI($week, $bmi);
    }

    public static function GetWeightGainByEvenWeekAndBMI($week, $bmi)
    {
        $model = self::model()->findByPk($week);
        if ($bmi < self::BMI1)
            return str_replace(',', '.', $model->w1);
        if ($bmi > self::BMI2) {
            return str_replace(',', '.', $model->w3);
        }
        return str_replace(',', '.', $model->w2);
    }

    public static function GetWeightGainByOddWeekAndBMI($week, $bmi)
    {
        if ($week == 1)
            $w1 = 0;
        else
            $w1 = self::GetWeightGainByEvenWeekAndBMI($week - 1, $bmi);
        $w2 = self::GetWeightGainByEvenWeekAndBMI($week + 1, $bmi);

        return round(($w1 + $w2) / 2, 2);
    }
    
    /**
     * Generates table with recommended weight by weeks (week => kilo)
     * 
     * @static
     * @param $weight_before
     * @param $bmi float body mass index
     * @return array table with recommended weight
     */
    public static function GetUserWeightArray($weight_before, $bmi)
    {
        $data = self::GetWeightGainArray($bmi);
        $result = array();
        for ($i = 1; $i <= 40; $i++) {
            $result[$i] = sprintf("%01.2f", $weight_before + $data[$i]);
        }

        return $result;
    }

    /**
     * Get weight gian array (week => kilo)
     *
     * @static
     * @param $bmi body mass index
     * @return array|mixed
     */
    static function GetWeightGainArray($bmi)
    {
        $data = Yii::app()->cache->get(self::CACHE_ID . self::GetBMIId($bmi));
        if ($data === false) {
            $data = array();
            $models = self::model()->findAll(array('order' => 'week ASC'));
            foreach ($models as $model) {
                if ($bmi < self::BMI1)
                    $data[$model->week] = $model->w1;
                elseif ($bmi > self::BMI2)
                    $data[$model->week] = $model->w3;
                else
                    $data[$model->week] = $model->w2;
            }
            $data[1] = round($data[2] / 2, 2);
            for ($i = 3; $i < 40; $i = $i + 2)
                $data[$i] = round(($data[$i - 1] + $data[$i + 1]) / 2, 2);

            Yii::app()->cache->set(self::CACHE_ID . self::GetBMIId($bmi), $data, 3600);
        }

        return $data;
    }

    /**
     * Returns body mass index Id.
     * 1 if bmi < 19.8
     * 2 if bmi >= 19.8 and bmi <= 26 
     * 3 if bmi > 26
     * 
     * @static
     * @param $bmi float body mass index
     * @return string
     */
    public static function GetBMIId($bmi)
    {
        if ($bmi < self::BMI1)
            return '1';
        elseif ($bmi > self::BMI2)
            return '3';
        else
            return '2';
    }
}