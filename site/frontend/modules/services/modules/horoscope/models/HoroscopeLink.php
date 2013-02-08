<?php

/**
 * This is the model class for table "services__horoscope_links".
 *
 * The followings are the available columns in table 'services__horoscope_links':
 * @property string $id
 * @property integer $horoscope_id
 * @property integer $today_link
 * @property integer $tomorrow_link
 * @property integer $month_link
 * @property integer $the_month_link
 * @property integer $month_horoscope_id
 * @property integer $year_link
 * @property integer $year
 *
 * The followings are the available model relations:
 * @property Horoscope $monthHoroscope
 * @property Horoscope $horoscope
 */
class HoroscopeLink extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HoroscopeLink the static model class
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
        return 'services__horoscope_links';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('horoscope_id', 'required'),
            array('horoscope_id, today_link, tomorrow_link, month_link, the_month_link, month_horoscope_id, year_link, year', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, horoscope_id, today_link, tomorrow_link, month_link, the_month_link, month_horoscope_id, year_link, year', 'safe', 'on' => 'search'),
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
            'monthHoroscope' => array(self::BELONGS_TO, 'ServicesHoroscope', 'month_horoscope_id'),
            'horoscope' => array(self::BELONGS_TO, 'ServicesHoroscope', 'horoscope_id'),
        );
    }

    /**
     * @param $horoscope Horoscope
     */
    public function generateLinks($horoscope)
    {
        if (self::model()->exists('horoscope_id=' . $horoscope->id))
            return;

        $this->horoscope = $horoscope;
        $this->horoscope_id = $horoscope->id;

        $this->generateTodayLink();
        $this->generateTomorrowLink();
        $this->generateMonthLink();
        $this->generateYearLink();
    }

    /**
     * Выбираем анкор для ссылки на "гороскоп на сегодня"
     * Выбираем тот который использовался меньше всего раз
     */
    public function generateTodayLink()
    {
        $counts = $this->getLinkAnchorsCounts('today_link');

        $this->today_link = $this->getUnusedAnchor($counts, $this->today_anchors);
        if (empty($this->today_link))
            $this->today_link = $this->getBestLinkAnchor($counts);
    }

    /**
     * Выбираем анкор для ссылки на "гороскоп на завтра"
     * Выбираем тот который использовался меньше всего раз
     */
    public function generateTomorrowLink()
    {
        $counts = $this->getLinkAnchorsCounts('tomorrow_link');

        $this->tomorrow_link = $this->getUnusedAnchor($counts, $this->today_anchors);
        if (empty($this->tomorrow_link))
            $this->tomorrow_link = $this->getBestLinkAnchor($counts);
    }

    /**
     * Выбираем анкор для ссылки на "гороскоп на месяц"
     * Выбираем тот который использовался меньше всего раз
     */
    public function generateMonthLink()
    {

    }

    /**
     * Выбираем анкор для ссылки на "гороскоп на год"
     * Выбираем тот который использовался меньше всего раз
     */
    public function generateYearLink()
    {

    }

    /**
     * Находим лучший анкор для ссылки, то есть тот с которым стоит меньше всего ссылок
     */
    public function getBestLinkAnchor($counts)
    {
        $min = 1000000;
        $best_anchor = 1;
        foreach ($counts as $count) {
            if ($count['count'] < $min) {
                $min = $count['count'];
                $best_anchor = $count['link_type'];
            }
        }

        return $best_anchor;
    }

    /**
     * Получить анкор, который еще ни разу не использовался
     * Если нету таких, возвращает null
     */
    public function getUnusedAnchor($counts, $anchors)
    {
        foreach ($anchors as $anchor_id => $anchor) {
            $used = false;
            foreach ($counts as $count)
                if ($count['link_type'] == $anchor_id) {
                    $used = true;
                    break;
                }

            if (!$used)
                return $anchor_id;
        }

        return null;
    }

    /**
     * Возвращает суммарное кол-во анкоров каждого вида
     *
     * @param $col string
     * @return array
     */
    public function getLinkAnchorsCounts($col)
    {
        return Yii::app()->db->createCommand()
            ->select($col . ' as link_type, count(*) as count')
            ->from($this->tableName())
            ->group($col)
            ->queryAll();
    }


    //****************************************************************************************************/
    /********************************************** Link anchors *****************************************/
    /*****************************************************************************************************/

    private $today_anchors = array(
        1 => '{zodiac} на сегодня',
        2 => 'Гороскоп на сегодня {zodiac}',
        3 => '{zodiac} на сегодня любовный гороскоп',
        4 => '{zodiac} гороскоп на сегодня любовный гороскоп',
        5 => '{zodiac} гороскоп на сегодня завтра',
        6 => '{zodiac} женщина на сегодня',
        7 => 'Гороскоп на сегодня {zodiac} женщина',
    );

    private $tomorrow_anchors = array(
        1 => '{zodiac} на завтра',
        2 => 'Гороскоп на завтра {zodiac}',
        3 => 'Любовный гороскоп на завтра {zodiac}',
        4 => '{zodiac} женщина на завтра',
        5 => 'Гороскоп на завтра {zodiac} женщина',
        6 => '{zodiac} сегодня завтра',
        7 => 'Гороскоп {zodiac} сегодня завтра',
    );

    public function getTodayKeyword($i)
    {
        switch ($i) {
            case 1:
                return $this->horoscope->zodiacText() . ' на сегодня';
            case 2:
                return 'Гороскоп на сегодня ' . $this->horoscope->zodiacText();
            case 3:
                return $this->horoscope->zodiacText() . ' на сегодня любовный';
            case 4:
                return $this->horoscope->zodiacText() . ' гороскоп на сегодня любовный гороскоп';
            case 5:
                return $this->horoscope->zodiacText() . ' гороскоп на сегодня любовный';
            case 6:
                return $this->horoscope->zodiacText() . ' гороскоп на сегодня завтра';
            case 7:
                return $this->horoscope->zodiacText() . ' женщина на сегодня';
            case 8:
                return 'Гороскоп на сегодня ' . $this->horoscope->zodiacText() . ' женщина';
        }

        return '';
    }
}