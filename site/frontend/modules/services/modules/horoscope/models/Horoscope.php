<?php

/**
 * This is the model class for table "services__horoscope".
 *
 * The followings are the available columns in table 'services__horoscope':
 * @property integer $id
 * @property integer $zodiac
 * @property integer $year
 * @property integer $month
 * @property string $date
 * @property string $text
 * @property string $health
 * @property string $career
 * @property string $finance
 * @property string $personal
 * @property string $good_days
 * @property string $bad_days
 */
class Horoscope extends HActiveRecord
{
    public $type;
    public $good_days_array = array();
    public $bad_days_array = array();

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

    public $zodiac_list2 = array(
        '1' => 'Овна',
        '2' => 'Тельца',
        '3' => 'Близнецов',
        '4' => 'Рака',
        '5' => 'Льва',
        '6' => 'Девы',
        '7' => 'Весов',
        '8' => 'Скорпиона',
        '9' => 'Стрельца',
        '10' => 'Козерога',
        '11' => 'Водолея',
        '12' => 'Рыб',
    );

    public $zodiac_list3 = array(
        '1' => 'Овнов',
        '2' => 'Тельцов',
        '3' => 'Близнецов',
        '4' => 'Раков',
        '5' => 'Львов',
        '6' => 'Дев',
        '7' => 'Весов',
        '8' => 'Скорпионов',
        '9' => 'Стрельцов',
        '10' => 'Козерогов',
        '11' => 'Водолеев',
        '12' => 'Рыб',
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
        '2' => array('start' => array(21, 4), 'end' => array(20, 5),),
        '3' => array('start' => array(21, 5), 'end' => array(21, 6),),
        '4' => array('start' => array(22, 6), 'end' => array(22, 7),),
        '5' => array('start' => array(23, 7), 'end' => array(23, 8),),
        '6' => array('start' => array(24, 8), 'end' => array(23, 9),),
        '7' => array('start' => array(24, 9), 'end' => array(23, 10),),
        '8' => array('start' => array(24, 10), 'end' => array(22, 11),),
        '9' => array('start' => array(23, 11), 'end' => array(21, 12),),
        '10' => array('start' => array(22, 12), 'end' => array(20, 1),),
        '11' => array('start' => array(21, 1), 'end' => array(20, 2),),
        '12' => array('start' => array(21, 2), 'end' => array(20, 3),),
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
            array('zodiac', 'required'),
            array('zodiac, year, month', 'numerical', 'integerOnly' => true),
            array('text', 'default', 'value' => ''),
            array('good_days, bad_days', 'length', 'max' => 1024),
            array('date, health, career, finance, personal, type', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, zodiac, year, month, date, text', 'safe', 'on' => 'search'),
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
            'links' => array(self::HAS_ONE, 'HoroscopeLink', 'horoscope_id'),
        );
    }

    public function scopes()
    {
        return array(
            'sortByZodiac' => array(
                'order' => 'zodiac asc',
            ),
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
            'month' => 'Месяц',
            'date' => 'Дата',
            'text' => 'Прогноз',
            'health' => 'Здоровье',
            'career' => 'Карьера',
            'finance' => 'Финансы',
            'personal' => 'Личная жизнь',
            'good_days' => 'Благоприятные дни',
            'bad_days' => 'Неблагоприятные дни',
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
        $criteria->compare('month', $this->month);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('health', $this->health, true);
        $criteria->compare('career', $this->career, true);
        $criteria->compare('finance', $this->finance, true);
        $criteria->compare('personal', $this->personal, true);
        $criteria->compare('good_days', $this->good_days, true);
        $criteria->compare('bad_days', $this->bad_days, true);
        $criteria->order = 'id desc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            ),
            'pingable' => array(
                'class' => 'site.common.behaviors.PingableBehavior',
            ),
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            if ($this->type == 1) {
                $exist = Horoscope::model()->findByAttributes(array(
                    'date' => $this->date,
                    'zodiac' => $this->zodiac,
                ));
                if ($exist)
                    $this->addError('date', 'Гороскоп на эту дату уже есть');
            } elseif ($this->type == 2) {
                $exist = Horoscope::model()->findByAttributes(array(
                    'year' => $this->year,
                    'month' => $this->month,
                    'zodiac' => $this->zodiac,
                ));
                if ($exist)
                    $this->addError('month', 'Гороскоп на этот месяц уже есть');
            } elseif ($this->type == 3) {
                $exist = Horoscope::model()->findByAttributes(array(
                    'year' => $this->year,
                    'month' => null,
                    'zodiac' => $this->zodiac,
                ));
                if ($exist)
                    $this->addError('year', 'Гороскоп на этот год уже есть');
            }
        }


        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        if ($this->type == 1) {
            $this->year = null;
            $this->month = null;
        } elseif ($this->type == 2) {
            $this->date = null;
        } elseif ($this->type == 3) {
            $this->month = null;
            $this->date = null;
        }

        return parent::beforeSave();
    }

    public function getAuthor()
    {
        return User::model()->findByPk(User::HAPPY_GIRAFFE);
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

    public function zodiacText2()
    {
        return $this->zodiac_list2[$this->zodiac];
    }

    public function zodiacText3()
    {
        return $this->zodiac_list3[$this->zodiac];
    }

    public function zodiacDates()
    {
        return $this->zodiac_dates[$this->zodiac]['start'][0] . '.'
            . sprintf("%02d", $this->zodiac_dates[$this->zodiac]['start'][1])
            . ' - ' . $this->zodiac_dates[$this->zodiac]['end'][0] . '.'
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

    public function getForecastText()
    {
        if ($this->onYear())
            return $this->health;
        else
            return $this->text;
    }

    public function getFormattedText()
    {
        return Str::strToParagraph($this->text);
    }

    public function onYear()
    {
        if (!empty($this->year) && empty($this->month))
            return true;
        return false;
    }

    public function onMonth()
    {
        if (!empty($this->month))
            return true;
        return false;
    }

    public function getType()
    {
        if ($this->onYear())
            return 'year';
        if ($this->onMonth())
            return 'month';
        if (!empty($this->date)) {
            if ($this->date == date("Y-m-d"))
                return 'today';
            if ($this->date == date("Y-m-d", strtotime('+1 day')))
                return 'tomorrow';
        }
        return '';
    }

    public static function getZodiacPhoto($zodiac_id)
    {
        if (empty($zodiac_id))
            return '/images/widget/horoscope/big/0.png';
        return '/images/widget/horoscope/big/' . $zodiac_id . '.png';
    }

    public function getZodiacSlug($zodiac_id = null)
    {
        if (empty($zodiac_id))
            return $this->zodiac_list_eng[$this->zodiac];
        else
            return $this->zodiac_list_eng[$zodiac_id];
    }

    public static function getZodiacTitle($zodiac_id)
    {
        return Horoscope::model()->zodiac_list[$zodiac_id];
    }

    public static function getZodiacTitle2($zodiac_id)
    {
        return Horoscope::model()->zodiac_list2[$zodiac_id];
    }

    public function calculateMonthDays()
    {
        $days = explode(',', $this->good_days);
        foreach ($days as $day)
            if (!empty($day))
                $this->good_days_array [] = trim($day);

        $days = explode(',', $this->bad_days);
        foreach ($days as $day)
            if (!empty($day))
                $this->bad_days_array [] = trim($day);
    }

    public function CalculateMonthData()
    {
        $data = array();

        $skip = date("w", mktime(0, 0, 0, (int)$this->month, 1, (int)$this->year)) - 1; // узнаем номер дня недели
        if ($skip < 0)
            $skip = 6;

        $daysInMonth = date("t", mktime(0, 0, 0, (int)$this->month, 1, (int)$this->year)); // узнаем число дней в месяце
        $day = 1; // для цикла далее будем увеличивать значение
        $num = 1;
        for ($i = 0; $i < 6; $i++) { // Внешний цикл для недель 6 с неполыми

            for ($j = 0; $j < 7; $j++) { // Внутренний цикл для дней недели

                if (($skip > 0) || ($day > $daysInMonth)) { // пустые ячейки до 1 го дня

                    $data[$num] = array('', '');
                    $skip--;

                } else {
                    $data[$num] = array($day, $this->GetDayData($day));
                    $day++; // увеличиваем $day
                }
                $num++;
            }

            if ($day > $daysInMonth)
                break;
        }

        return $data;
    }

    public function GetDayData($day)
    {
        if (in_array($day, $this->good_days_array))
            return 'good';
        if (in_array($day, $this->bad_days_array))
            return 'bad';
        return '';
    }


    public function isCurrentMonth()
    {
        return empty($_GET['month']);
    }

    public function isCurrentYear()
    {
        return empty($_GET['year']);
    }

    public function getOtherZodiacUrl($zodiac)
    {
        if ($this->onMonth()) {
            return $this->isCurrentMonth() ?
                Yii::app()->controller->createUrl('month', array('zodiac' => $zodiac))
                :
                Yii::app()->controller->createUrl('month', array('zodiac' => $zodiac, 'month' => $_GET['month']));
        }
        if ($this->onYear()) {
            return $this->isCurrentYear() ?
                Yii::app()->controller->createUrl('year', array('zodiac' => $zodiac))
                :
                Yii::app()->controller->createUrl('year', array('zodiac' => $zodiac, 'year' => $_GET['year']));
        }

        if (in_array(Yii::app()->controller->action->id, array('tomorrow', 'today', 'yesterday')))
            return Yii::app()->controller->createUrl(Yii::app()->controller->action->id, array('zodiac' => $zodiac));

        if (Yii::app()->controller->action->id == 'date')
            return Yii::app()->controller->createUrl(Yii::app()->controller->action->id, array(
                'zodiac' => $zodiac,
                'date' => $_GET['date']
            ));

        return '#';
    }

    public function getOtherZodiacTitle($zodiac)
    {
        if ($this->onMonth()) {
            return $this->isCurrentMonth() ?
                'гороскоп ' . Horoscope::getZodiacTitle2($zodiac) . ' на месяц'
                :
                'гороскоп ' . Horoscope::getZodiacTitle2($zodiac) . ' на ' . Yii::app()->dateFormatter->format('MMMM yyyy', strtotime($this->date)) . ' года';
        }
        if ($this->onYear()) {
            return $this->isCurrentYear() ?
                'гороскоп ' . Horoscope::getZodiacTitle2($zodiac) . ' на год'
                :
                'гороскоп ' . Horoscope::getZodiacTitle2($zodiac) . ' на ' . $this->year . ' год';
        }

        if (Yii::app()->controller->action->id == 'tomorrow')
            return 'гороскоп ' . Horoscope::getZodiacTitle2($zodiac) . ' на завтра';
        if (Yii::app()->controller->action->id == 'today')
            return 'гороскоп ' . Horoscope::getZodiacTitle2($zodiac) . ' на сегодня';
        if (Yii::app()->controller->action->id == 'yesterday')
            return 'гороскоп ' . Horoscope::getZodiacTitle2($zodiac) . ' на вчера';

        if (Yii::app()->controller->action->id == 'date')
            return 'гороскоп ' . Horoscope::getZodiacTitle2($zodiac) . ' на ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($this->date)) . ' года';

        return '';
    }

    public function getUrl($absolute = false)
    {
        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';

        if (!empty($this->date))
            return Yii::app()->$method('/services/horoscope/default/date', array(
                'zodiac' => $this->getZodiacSlug(),
                'date' => $this->date
            ));
        if (!empty($this->year) && empty($this->month))
            if ($this->year == 2012)
                return Yii::app()->$method('/services/horoscope/default/year', array(
                    'zodiac' => $this->getZodiacSlug()
                ));
            else
                return Yii::app()->$method('/services/horoscope/default/year', array(
                    'zodiac' => $this->getZodiacSlug(),
                    'year' => $this->year
                ));
        if (!empty($this->year) && !empty($this->month))
            return Yii::app()->$method('/services/horoscope/default/month', array(
                'zodiac' => $this->getZodiacSlug(),
                'month' => $this->year . '-' . sprintf('%02d', $this->month),
            ));

        return '#';
    }

    public function getName()
    {
        $text = $this->zodiac_list2[$this->zodiac] . ' на ';
        if (!empty($this->date)) {
            if (Yii::app()->controller->action->id == 'today')
                return $text . 'сегодня';
            if (Yii::app()->controller->action->id == 'yesterday')
                return $text . 'вчера';
            if (Yii::app()->controller->action->id == 'tomorrow')
                return $text . 'завтра';

            return $text . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($this->date)) . ' года';
        }
        if ($this->onMonth())
            return $this->isCurrentMonth() ? $text . 'месяц' : $text . mb_strtolower(HDate::ruMonth($this->month), 'utf8') . ' ' . $this->year . ' года';
        if ($this->onYear())
            return $text . $this->year . ' год';

        return '';
    }

    public function getTitle()
    {
        if ($this->onYear())
            return 'Гороскоп ' . $this->zodiacText() . ' на ' . $this->year . ' год';
        ;
        if ($this->onMonth())
            return 'Гороскоп ' . $this->zodiacText() . ' на ' . HDate::ruMonth($this->month) . ' ' . $this->year . ' года';
        return 'Гороскоп ' . $this->zodiacText() . ' на ' .
            Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($this->date));
    }

    /*****************************************************************************************************************/
    /**************************************************** TEXTS ******************************************************/
    /*****************************************************************************************************************/

    public function getText()
    {
        if ($this->onMonth()) {
            return $this->isCurrentMonth() ? ServiceText::getText('horoscope', 'month_' . $this->zodiac) : '';
        }
        if ($this->onYear())
            return ServiceText::getText('horoscope', 'year_' . $this->zodiac);
        if ($this->date == date("Y-m-d"))
            return ServiceText::getText('horoscope', 'today_' . $this->zodiac);
        if ($this->date == date("Y-m-d", strtotime('-1 day')))
            return ServiceText::getText('horoscope', 'yesterday_' . $this->zodiac);
        if ($this->date == date("Y-m-d", strtotime('+1 day')))
            return ServiceText::getText('horoscope', 'tomorrow_' . $this->zodiac);

        return '';
    }

    /**
     * Что бы ни пророчил вам гороскоп Овна на 22 января 2013 года - помните, удача в ваших руках!
     *
     * @return string
     */
    public function getAdditionalText()
    {
        $text = 'Что бы ни пророчил вам гороскоп ';
        if (isset($_GET['date']) && strtotime('2013-02-01') <= strtotime($this->date)) {
            $text .= $this->zodiac_list2[$this->zodiac];
            $text .= ' на ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($this->date)) . ' года - помните, удача в ваших руках!';

            return $text;
        }
        if (isset($_GET['month']) && ($this->month > 1 && $this->year == 2013 || $this->year > 2013)) {
            $text .= $this->zodiac_list2[$this->zodiac];
            $text .= ' на ' . mb_strtolower(HDate::ruMonth($this->month), 'utf-8') . ' ' . $this->year . ' года - помните, удача в ваших руках!';

            return $text;
        }


        return '';
    }


    /*****************************************************************************************************************/
    /**************************************************** LINKING ****************************************************/
    /*****************************************************************************************************************/

    public function isNearbyZodiac($zodiac_id)
    {
        return $zodiac_id == $this->zodiac + 1 || $zodiac_id == $this->zodiac - 1
            || ($this->zodiac == 1 && $zodiac_id == 12) || ($this->zodiac == 12 && $zodiac_id == 1);
    }

    public function dateHoroscopeExist($date)
    {
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $this->zodiac, 'date' => date("Y-m-d", $date)));
        return $model !== null;
    }

    public function monthHoroscopeExist($month, $year)
    {
        $model = Horoscope::model()->findByAttributes(array(
            'zodiac' => $this->zodiac,
            'month' => $month,
            'year' => $year,
        ));
        return $model !== null;
    }

    public function yearHoroscopeExist($year)
    {
        if ($year < date("Y"))
            return false;
        $model = Horoscope::model()->findByAttributes(array(
            'zodiac' => $this->zodiac,
            'month' => null,
            'year' => $year,
        ));
        return $model !== null;
    }

    public function getPrevMonthLink()
    {
        $month = $this->month - 1;
        $year = $this->year;
        if ($month == 0) {
            $month = 12;
            $year--;
        }
        if (!$this->monthHoroscopeExist($month, $year))
            return '';
        $text = mb_strtolower(HDate::ruMonth($month), 'utf8') . ' ' . $year;

        return '<span>' . CHtml::link('Гороскоп ' . $this->zodiacText2() . ' на ' . $text, Yii::app()->controller->createUrl('month', array(
            'zodiac' => $this->getZodiacSlug(),
            'month' => $year . '-' . sprintf('%02d', $month),
        ))) . ' ←</span>';
    }

    public function getNextMonthLink($i = 1)
    {
        $month = $this->month + $i;
        $year = $this->year;
        if ($month > 12) {
            $month = $month - 12;
            $year++;
        }
        if (!$this->monthHoroscopeExist($month, $year))
            return '';
        $text = mb_strtolower(HDate::ruMonth($month), 'utf8') . ' ' . $year;

        $link = CHtml::link('Гороскоп ' . $this->zodiacText2() . ' на ' . $text, Yii::app()->controller->createUrl('month', array(
            'zodiac' => $this->getZodiacSlug(),
            'month' => $year . '-' . sprintf('%02d', $month),
        )));
        if ($i == 1)
            return '<span>→ ' . $link . '</span>';
        else
            return $link;
    }

    public function getPrevYearLink()
    {
        $year = $this->year - 1;
        return CHtml::link('Гороскоп ' . $this->zodiacText2() . ' на ' . $year . ' год', Yii::app()->controller->createUrl('year', array(
            'zodiac' => $this->getZodiacSlug(),
            'year' => $year,
        )));
    }

    public function getNextYearLink()
    {
        $year = $this->year + 1;
        return CHtml::link('Гороскоп ' . $this->zodiacText2() . ' на ' . $year . ' год', Yii::app()->controller->createUrl('year', array(
            'zodiac' => $this->getZodiacSlug(),
            'year' => $year,
        )));
    }

    public function getDateLinks()
    {
        $result = 'А еще';

        if (Yii::app()->controller->action->id == 'today') {
            //если на сегодня, показываем на вчера
            $result .= CHtml::link('Гороскоп ' . $this->zodiacText2() . ' на вчера', Yii::app()->controller->createUrl('yesterday', array('zodiac' => $this->getZodiacSlug())));
        } elseif (Yii::app()->controller->action->id == 'tomorrow') {
            //если на завтра, то выводим ссылки на 2 следующих дня
            if ($this->dateHoroscopeExist(strtotime('+2 days')))
                $result .= $this->getDateLink(strtotime('+2 days'));
            if ($this->dateHoroscopeExist(strtotime('+3 days')))
                $result .= $this->getDateLink(strtotime('+3 days'));
        } elseif (Yii::app()->controller->action->id == 'date') {
            if (isset($this->links)) {
                $result .= '<br>'.$this->links->getLinks();
            } else
                $result = '';
        } else
            $result = '';

        return $result;
    }

    public function getDateLink($date)
    {
        return CHtml::link('Гороскоп ' . $this->zodiacText2() . ' на ' . Yii::app()->dateFormatter->format('d MMMM', $date),
            Yii::app()->controller->createUrl('date', array(
                'zodiac' => $this->getZodiacSlug(),
                'date' => date("Y-m-d", $date),
            )));
    }

    public function getMetaDescription()
    {
        if (empty($this->month) && !empty($this->year))
            return $this->health;
        else
            return $this->text;
    }

    public function getRssContent()
    {
        if (empty($this->month) && !empty($this->year))
            return '<p><span class="red">Здоровье.</span>' . $this->health
                . '</p><p><span class="red">Карьера.</span>' . $this->career
                . '</p><p><span class="red">Финансы.</span>' . $this->finance
                . '</p><p><span class="red">Личная жизнь.</span>' . $this->personal . '</p>';
        else
            return $this->text;
    }
}