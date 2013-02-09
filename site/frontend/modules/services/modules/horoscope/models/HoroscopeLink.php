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
 *
 * The followings are the available model relations:
 * @property Horoscope $monthHoroscope
 * @property Horoscope $horoscope
 */
class HoroscopeLink extends HActiveRecord
{
    const MONTH_LINK_MONTH = 1;
    const MONTH_LINK_SOME_MONTH = 2;

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
            array('horoscope_id, today_link, tomorrow_link, month_link, the_month_link, month_horoscope_id, year_link', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, horoscope_id, today_link, tomorrow_link, month_link, the_month_link, month_horoscope_id, year_link', 'safe', 'on' => 'search'),
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
            'monthHoroscope' => array(self::BELONGS_TO, 'Horoscope', 'month_horoscope_id'),
            'horoscope' => array(self::BELONGS_TO, 'Horoscope', 'horoscope_id'),
        );
    }

    //*********************************************************************************************************/
    /********************************************** CREATE LINKS FOR VIEW *************************************/
    /**********************************************************************************************************/

    /**
     * Получить ссылки для вывода на странице гороскопа
     *
     * @return string
     */
    public function getLinks()
    {
        $links = array(
            $this->getTodayLink(),
            $this->getTomorrowLink(),
            $this->getMonthLink(),
            $this->getYearLink()
        );

        return implode('<br>', $links);
    }

    /**
     * @return string Ссылка "на сегодня"
     */
    public function getTodayLink()
    {
        $title = $this->replacePatterns($this->today_anchors[$this->today_link]);
        return CHtml::link($title, Yii::app()->controller->createUrl('today', array('zodiac' => $this->horoscope->getZodiacSlug())));
    }

    /**
     * @return string Ссылка "на завтра"
     */
    public function getTomorrowLink()
    {
        $title = $this->replacePatterns($this->tomorrow_anchors[$this->tomorrow_link]);
        return CHtml::link($title, Yii::app()->controller->createUrl('tomorrow', array('zodiac' => $this->horoscope->getZodiacSlug())));
    }

    /**
     * @return string Ссылка "на месяц"
     */
    public function getMonthLink()
    {
        $title = $this->replacePatterns($this->month_anchors[$this->month_link]);
        return CHtml::link($title, Yii::app()->controller->createUrl('month', array('zodiac' => $this->horoscope->getZodiacSlug())));
    }

    /**
     * @return string Ссылка "на год"
     */
    public function getYearLink()
    {
        $title = $this->replacePatterns($this->year_anchors[$this->year_link]);
        return CHtml::link($title, Yii::app()->controller->createUrl('year', array('zodiac' => $this->horoscope->getZodiacSlug())));
    }

    /**
     * Заменить шаблоны на конкретные слова в анкорах
     *
     * @param $text
     * @return mixed
     */
    public function replacePatterns($text)
    {
        $text = str_replace('{zodiac}', $this->horoscope->zodiacText(), $text);
        $text = str_replace('{zodiac2}', $this->horoscope->zodiacText2(), $text);
        $text = str_replace('{zodiac3}', $this->horoscope->zodiacText3(), $text);

        $text = str_replace('{year}', date("Y"), $text);

        $china_year = date("Y") % 12;
        $text = str_replace('{year_china}', $this->year_china[$china_year], $text);
        $text = str_replace('{year_china2}', $this->year_china2[$china_year], $text);

        return $text;
    }


    //****************************************************************************************************/
    /********************************************** LINK GENERATORS *************************************/
    /****************************************************************************************************/

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

        $this->save();
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

        $this->tomorrow_link = $this->getUnusedAnchor($counts, $this->tomorrow_anchors);
        if (empty($this->tomorrow_link))
            $this->tomorrow_link = $this->getBestLinkAnchor($counts);
    }

    /**
     * Выбираем анкор для ссылки на "гороскоп на месяц"
     * Выбираем тот который использовался меньше всего раз
     */
    public function generateMonthLink()
    {
        if ($this->getMonthLinkType() == self::MONTH_LINK_MONTH) {

        } else {

        }
    }

    /**
     * Выбираем анкор для ссылки на "гороскоп на год"
     * Выбираем тот который использовался меньше всего раз
     */
    public function generateYearLink()
    {
        //выбираем только текущий год или больше
        $counts = $this->getLinkAnchorsCounts('year_link');

        $this->year_link = $this->getUnusedAnchor($counts, $this->year_anchors);
        if (empty($this->year_link))
            $this->year_link = $this->getBestLinkAnchor($counts);
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
     * Какого типа ссылку на месяц ставить - на конкретный месяц или просто "на месяц"
     * ставим 50 / 50, поэтому какого типа меньше того и ставим
     *
     * @return int
     */
    public function getMonthLinkType()
    {
        $all_count = Yii::app()->db->createCommand()->select('count(*)')->from($this->tableName())->queryScalar();
        $month_count = Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from($this->tableName())
            ->where('some_month_link IS NULL')
            ->queryScalar();

        return ($month_count * 2 <= $all_count) ? self::MONTH_LINK_MONTH : self::MONTH_LINK_SOME_MONTH;
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

    private $month_anchors = array(
        1 => '{zodiac} месяц',
        2 => 'Гороскоп на месяц {zodiac}',
        3 => 'Гороскоп по месяцам {zodiac} {year}',
    );

    private $some_month_anchors = array(
        1 => '{zodiac} на {month}',
        2 => 'Гороскоп на {month} {zodiac}',
        3 => '{zodiac} {month} {year}',
        4 => 'Гороскоп на {month} {year} {zodiac}',
        5 => 'Гороскоп {year} {zodiac} {month}',
        6 => 'Любовный гороскоп на {month} {zodiac}',
        7 => 'Гороскоп {zodiac} женщина на {month}',
        8 => 'Гороскоп {zodiac} женщина на {month}',
        9 => 'Любовный гороскоп {zodiac} {month} {year}',
    );

    private $year_anchors = array(
        '{zodiac} {year}',
        'Гороскоп {zodiac} {year}',
        'Гороскоп {zodiac} на {year} год',
        '{year} год для {zodiac2}',
        '{zodiac} женщина {year}',
        'Гороскоп {zodiac} женщина на {year}',
        'Любовный гороскоп {zodiac} {year}',
        '{zodiac} мужчина {year}',
        'Гороскоп {zodiac} {year} год любовный',
        'Гороскоп на {year} {zodiac} мужчина',
        'Гороскоп {year_china2} {year} для {zodiac2}',
        'Год {year_china2} {year} гороскоп {zodiac}',
        '{zodiac} {year_china} гороскоп на {year}',
        'Что ждет {zodiac3} в {year}',
        '{zodiac} прогноз на {year}',
        '{year} год для {zodiac2} женщины',
        '{zodiac} прогноз на {year} год'
    );

    private $year_china = array(
        1 => 'обезьяна',
        2 => 'петух',
        3 => 'собака',
        4 => 'свинья',
        5 => 'крыса',
        6 => 'бык',
        7 => 'тигр',
        8 => 'кролик',
        9 => 'дракон',
        10 => 'змея',
        11 => 'лошадь',
        12 => 'коза',
    );

    private $year_china2 = array(
        0 => 'обезьяны',
        1 => 'петуха',
        2 => 'собаки',
        3 => 'свиньи',
        4 => 'крысы',
        5 => 'быка',
        6 => 'тигра',
        7 => 'кролика',
        8 => 'дракона',
        9 => 'змеи',
        10 => 'лошади',
        11 => 'козы',
    );
}