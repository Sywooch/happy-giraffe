<?php

/**
 * This is the model class for table "services__horoscope".
 *
 * The followings are the available columns in table 'services__horoscope':
 * @property integer $id
 * @property integer $zodiac
 * @property integer $year
 * @property integer $month
 * @property integer $week
 * @property string $date
 * @property string $text
 */
class Horoscope extends HActiveRecord
{
    public $type;

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

    public $zodiac_list_eng = array(
        '1' => 'aries',
        '2' => 'taurus',
        '3' => 'gemini',
        '4' => 'cancer',
        '5' => 'leo',
        '6' => 'virgo',
        '7' => 'libra',
        '8' => 'scorpio',
        '9' => 'sagittarius',
        '10' => 'capricorn',
        '11' => 'aquarius',
        '12' => 'pisces',
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
            array('zodiac, text', 'required'),
            array('zodiac, year, week, month', 'numerical', 'integerOnly' => true),
            array('date, type, month', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, zodiac, year, week, month, date, text', 'safe', 'on' => 'search'),
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
            'year' => 'Год',
            'week' => 'Неделя',
            'month' => 'Месяц',
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
        $criteria->compare('year', $this->year);
        $criteria->compare('week', $this->week);
        $criteria->compare('month', $this->month);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('text', $this->text, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave()
    {
        if ($this->type == 1) {
            $this->year = null;
            $this->month = null;
            $this->week = null;
        } elseif ($this->type == 2) {
            $this->date = null;
        } elseif ($this->type == 3) {
            $this->month = null;
            $this->week = null;
            $this->date = null;
        }

        return parent::beforeSave();
    }

    public function getZodiacId($name)
    {
        foreach ($this->zodiac_list_eng as $key => $zodiac)
            if ($zodiac == $name)
                return $key;

        return null;
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

    public function someZodiacDates($zodiac)
    {
        return $this->zodiac_dates[$zodiac]['start'][0] . '.'
            . sprintf("%02d", $this->zodiac_dates[$zodiac]['start'][1])
            . '-' . $this->zodiac_dates[$zodiac]['end'][0] . '.'
            . sprintf('%02d', $this->zodiac_dates[$zodiac]['end'][1]);
    }

    public function dateText()
    {
        if (empty($this->date))
            return '';
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

    public function getFormattedText()
    {
        return Str::strToParagraph($this->text);
    }

    public function onYear()
    {
        if (!empty($this->year) && empty($this->month) && empty($this->week))
            return true;
        return false;
    }

    public function onMonth()
    {
        if (!empty($this->month))
            return true;
        return false;
    }

    public function onWeek()
    {
        if (!empty($this->week))
            return true;
        return false;
    }

    public function getType()
    {
        if ($this->onYear())
            return 'year';
        if ($this->onMonth())
            return 'month';
        if ($this->onWeek())
            return 'week';
        if (!empty($this->date))
            return 'view';
        return '';
    }

    public static function getZodiacPhoto($zodiac_id){
        if (empty($zodiac_id))
            return '';
        return '/images/widget/horoscope/big/'.$zodiac_id.'.png';
    }

    public static function getZodiacSlug($zodiac_id){
        return Horoscope::model()->zodiac_list_eng[$zodiac_id];
    }
}