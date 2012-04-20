<?php

/**
 * This is the model class for table "services__horoscope".
 *
 * The followings are the available columns in table 'services__horoscope':
 * @property integer $id
 * @property integer $zodiac
 * @property string $date
 * @property string $text
 */
class Horoscope extends CActiveRecord
{
    public $zodiac_list = array(
        '1' => 'Овен',
        '2' => 'Телец',
        '3' => 'Близнецы',
        '4' => 'Рак',
        '5' => 'Лев',
        '6' => 'Дева',
        '7' => 'Весы',
        '8' => 'Скорпион',
        '9' => 'Стрелец',
        '10' => 'Козерог',
        '11' => 'Водолей',
        '12' => 'Рыбы',
    );

    public $zodiac_dates = array(
        '1' => array('start' => array(21, 3), 'end' => array(20, 4),),
        '2' => array('start' => array(21, 4), 'end' => array(21, 5),),
        '3' => array('start' => array(22, 5), 'end' => array(21, 6),),
        '4' => array('start' => array(22, 6), 'end' => array(22, 7),),
        '5' => array('start' => array(23, 7), 'end' => array(23, 8),),
        '6' => array('start' => array(24, 8), 'end' => array(23, 9),),
        '7' => array('start' => array(24, 9), 'end' => array(23, 10),),
        '8' => array('start' => array(24, 10), 'end' => array(22, 11),),
        '9' => array('start' => array(23, 11), 'end' => array(21, 12),),
        '10' => array('start' => array(22, 12), 'end' => array(20, 1),),
        '11' => array('start' => array(21, 1), 'end' => array(21, 2),),
        '12' => array('start' => array(19, 2), 'end' => array(19, 3),),
    );

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Horoscope the static model class
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
        return 'services__horoscope';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('zodiac, date, text', 'required'),
            array('zodiac', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, zodiac, date, text', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'zodiac' => 'Знак зодиака',
            'date' => 'Дата',
            'text' => 'Прогноз',
        );
    }

    public function defaultScope()
    {
        return array(
            'order' => 'date desc',
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
        $criteria->compare('zodiac', $this->zodiac);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('text', $this->text, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 12),
        ));
    }

    public function zodiacText()
    {
        return $this->zodiac_list[$this->zodiac];
    }

    public function zodiacDates()
    {
        return $this->zodiac_dates[$this->zodiac]['start'][0] . '.'
            . sprintf("%02d", $this->zodiac_dates[$this->zodiac]['start'][1])
            . '-' . $this->zodiac_dates[$this->zodiac]['end'][0] . '.'
            . sprintf('%02d', $this->zodiac_dates[$this->zodiac]['end'][1]);
    }

    public function dateText()
    {
        return Yii::app()->dateFormatter->format("d MMMM, y", strtotime($this->date));
    }

    public function getDateZodiac($date)
    {
        $dt = strtotime($date);
        $day = date('d', $dt);
        $month = date('m', $dt);

        foreach ($this->zodiac_dates as $zodiac_id => $zodiac_date) {
            if (($month == $zodiac_date['start'][1])) {
                if ($day >= $zodiac_date['start'][0])
                    return $zodiac_id;
            } elseif ($month == $zodiac_date['end'][1]) {
                if ($day <= $zodiac_date['end'][0])
                    return $zodiac_id;
            }
        }

        return null;
    }
}