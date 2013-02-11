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
 * @property integer $some_month
 * @property integer $some_month_link
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
        return array(
            array('horoscope_id', 'required'),
            array('horoscope_id, today_link, tomorrow_link, month_link, some_month_link, year_link', 'numerical', 'integerOnly' => true),
            //array('id, horoscope_id, today_link, tomorrow_link, month_link, some_month, some_month_link, year_link', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
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

        foreach ($links as $key => $link)
            if (empty($link))
                unset($links[$key]);

        return implode('<br>', $links);
    }

    /**
     * @return string Ссылка "на сегодня"
     */
    private function getTodayLink()
    {
        $title = $this->replacePatterns($this->today_link_anchors[$this->today_link]);
        return CHtml::link($title, Yii::app()->controller->createUrl('today', array('zodiac' => $this->horoscope->getZodiacSlug())));
    }

    /**
     * @return string Ссылка "на завтра"
     */
    private function getTomorrowLink()
    {
        $title = $this->replacePatterns($this->tomorrow_link_anchors[$this->tomorrow_link]);
        return CHtml::link($title, Yii::app()->controller->createUrl('tomorrow', array('zodiac' => $this->horoscope->getZodiacSlug())));
    }

    /**
     * @return string Ссылка "на месяц"
     */
    private function getMonthLink()
    {
        if (empty($this->some_month)) {
            $title = $this->replacePatterns($this->month_link_anchors[$this->month_link]);
            return CHtml::link($title, Yii::app()->controller->createUrl('month', array('zodiac' => $this->horoscope->getZodiacSlug())));
        }

        $t = strtotime($this->some_month . '-01');
        $month = date("m", $t);
        $year = date("Y", $t);

        if (!$this->monthHoroscopeExist($year, $month, $this->horoscope->zodiac))
            return null;

        $title = $this->replacePatterns($this->some_month_link_anchors[$this->some_month_link], $year, $month);
        return CHtml::link($title, Yii::app()->controller->createUrl('month', array('zodiac' => $this->horoscope->getZodiacSlug(), 'month' => $this->some_month)));
    }

    private function monthHoroscopeExist($year, $month, $zodiac)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('zodiac', $zodiac);
        $criteria->compare('month', $month);
        $criteria->compare('year', $year);

        return Horoscope::model()->find($criteria) !== null;
    }

    /**
     * @return string Ссылка "на год"
     */
    private function getYearLink()
    {
        //вычисляем на какой год ставим ссылку
        //если гороскоп до 1 июля, то на текущий, иначе на следующий
        $t = strtotime($this->horoscope->date);
        if (date("m", $t) >= 7)
            $year = date("Y", $t) + 1;
        else
            $year = date("Y", $t);

        //год не раньше 2013
        if ($year < 2013)
            $year = 2013;

        if (!$this->yearHoroscopeExist($year, $this->horoscope->zodiac))
            return null;

        $title = $this->replacePatterns($this->year_link_anchors[$this->year_link], $year);
        return CHtml::link($title, Yii::app()->controller->createUrl('year', array('zodiac' => $this->horoscope->getZodiacSlug(), 'year' => $year)));
    }

    private function yearHoroscopeExist($year, $zodiac)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'month IS NULL';
        $criteria->compare('zodiac', $zodiac);
        $criteria->compare('year', $year);

        return Horoscope::model()->find($criteria) !== null;
    }

    /**
     * Заменить шаблоны на конкретные слова в анкорах
     *
     * @param $text
     * @param int|null $year
     * @param int|null $month
     * @return mixed
     */
    private function replacePatterns($text, $year = null, $month = null)
    {
        $text = str_replace('{zodiac}', $this->horoscope->zodiacText(), $text);
        $text = str_replace('{zodiac2}', $this->horoscope->zodiacText2(), $text);
        $text = str_replace('{zodiac3}', $this->horoscope->zodiacText3(), $text);

        if (!empty($year)) {
            $text = str_replace('{year}', $year, $text);

            $china_year = $year % 12;
            $text = str_replace('{year_china}', $this->year_china[$china_year], $text);
            $text = str_replace('{year_china2}', $this->year_china2[$china_year], $text);
        }

        if (!empty($month)) {
            $month = mb_strtolower(HDate::ruMonth($month), 'utf-8');
            $text = str_replace('{month}', $month, $text);
        }

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
    private function generateTodayLink()
    {
        $this->today_link = $this->getLinkAnchor('today_link');
    }

    /**
     * Выбираем анкор для ссылки на "гороскоп на завтра"
     * Выбираем тот который использовался меньше всего раз
     */
    private function generateTomorrowLink()
    {
        $this->tomorrow_link = $this->getLinkAnchor('tomorrow_link');
    }

    /**
     * Выбираем анкор для ссылки на "гороскоп на год"
     * Выбираем тот который использовался меньше всего раз
     */
    private function generateYearLink()
    {
        //выбираем только текущий год или больше
        $this->year_link = $this->getLinkAnchor('year_link');
    }

    //****************************************************************************************************/
    /*********************************** Алгоритм генерации ссылки на месяц ******************************/
    /*****************************************************************************************************/

    /**
     * Выбираем анкор для ссылки на "гороскоп на месяц"
     * Выбираем тот который использовался меньше всего раз
     */
    private function generateMonthLink()
    {
        if ($this->getMonthLinkType() == self::MONTH_LINK_MONTH) {
            $counts = $this->getLinkAnchorsCounts('month_link');

            $this->month_link = $this->getUnusedAnchor($counts, $this->month_link_anchors);
            if (empty($this->month_link))
                $this->month_link = $this->getBestLinkAnchor($counts);
        } else {
            $this->generateSomeMonthLink();
        }
    }

    /**
     * Выбираем анкор для ссылки на "гороскоп на конкретный месяц"
     */
    private function generateSomeMonthLink()
    {
        //до 1 июня 2013 ставим на март - август 2013
        $t = strtotime($this->horoscope->date);
        if ($t < strtotime('2013-06-01 00:00:00')) {
            //на какой из этих 6-ти месяцев меньше ссылок на тот и ставим
            $months = array('2013-03', '2013-04', '2013-05', '2013-06', '2013-07', '2013-08');
            $month = $this->getMonthForLink($months);
        } else {
            //после - на месяц через 3
            $month = date("Y-m", strtotime('+3 month', $t));
        }

        $this->some_month = $month;
        $this->some_month_link = $this->getLinkAnchor('some_month_link', 'some_month="' . $month . '"');
    }

    /**
     * Выбираем месяц из нескольких, на который меньше всего ссылок
     *
     * @param $months array
     */
    private function getMonthForLink($months)
    {
        $min = 1000000;
        $best_month = $months[0];
        foreach ($months as $month) {
            $count = Yii::app()->db->createCommand()
                ->select('count(*)')
                ->from($this->tableName())
                ->where('some_month=:month', array(':month' => $month))
                ->queryScalar();
            if ($count < $min) {
                $min = $count;
                $best_month = $month;
            }
        }

        return $best_month;
    }

    /**
     * Какого типа ссылку на месяц ставить - на конкретный месяц или просто "на месяц"
     * ставим в соотношении 1:5 где 5 - на конкретный месяц
     *
     * @return int
     */
    private function getMonthLinkType()
    {
        $all_count = Yii::app()->db->createCommand()->select('count(*)')->from($this->tableName())->queryScalar();
        $month_count = Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from($this->tableName())
            ->where('some_month IS NULL')
            ->queryScalar();

        return ($month_count * 5 <= $all_count) ? self::MONTH_LINK_MONTH : self::MONTH_LINK_SOME_MONTH;
    }

    //****************************************************************************************************/
    /****************************** Общие методы для генерации анокоров **********************************/
    /*****************************************************************************************************/

    /**
     * Возвращает лучший анкор для ссылки - тот который был использован меньше всего раз
     *
     * @param $col string
     * @param null $condition
     * @return int
     */
    private function getLinkAnchor($col, $condition = null)
    {
        $counts = $this->getLinkAnchorsCounts($col, $condition);

        $col = $col . '_anchors';
        $result = $this->getUnusedAnchor($counts, $this->$col);
        if (empty($result))
            $result = $this->getBestLinkAnchor($counts);

        return $result;
    }

    /**
     * Находим лучший анкор для ссылки, то есть тот с которым стоит меньше всего ссылок
     */
    private function getBestLinkAnchor($counts)
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
    private function getUnusedAnchor($counts, $anchors)
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
     * @param $condition string
     * @return array
     */
    private function getLinkAnchorsCounts($col, $condition = null)
    {
        if (!empty($condition))
            $condition = $col . ' IS NOT NULL AND ' . $condition;
        else
            $condition = $col . ' IS NOT NULL';

        return Yii::app()->db->createCommand()
            ->select($col . ' as link_type, count(*) as count')
            ->from($this->tableName())
            ->where($condition)
            ->group($col)
            ->queryAll();
    }

    //****************************************************************************************************/
    /********************************************** Link anchors *****************************************/
    /*****************************************************************************************************/

    private $today_link_anchors = array(
        1 => '{zodiac} на сегодня',
        2 => 'Гороскоп на сегодня {zodiac}',
        3 => '{zodiac} на сегодня любовный гороскоп',
        4 => '{zodiac} гороскоп на сегодня любовный гороскоп',
        5 => '{zodiac} гороскоп на сегодня завтра',
        6 => '{zodiac} женщина на сегодня',
        7 => 'Гороскоп на сегодня {zodiac} женщина',
    );

    private $tomorrow_link_anchors = array(
        1 => '{zodiac} на завтра',
        2 => 'Гороскоп на завтра {zodiac}',
        3 => 'Любовный гороскоп на завтра {zodiac}',
        4 => '{zodiac} женщина на завтра',
        5 => 'Гороскоп на завтра {zodiac} женщина',
        6 => '{zodiac} сегодня завтра',
        7 => 'Гороскоп {zodiac} сегодня завтра',
    );

    private $month_link_anchors = array(
        1 => '{zodiac} месяц',
        2 => 'Гороскоп на месяц {zodiac}',
        3 => 'Гороскоп по месяцам {zodiac} {year}',
    );

    private $some_month_link_anchors = array(
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

    private $year_link_anchors = array(
        1 => '{zodiac} {year}',
        2 => 'Гороскоп {zodiac} {year}',
        3 => 'Гороскоп {zodiac} на {year} год',
        4 => '{year} год для {zodiac2}',
        5 => '{zodiac} женщина {year}',
        6 => 'Гороскоп {zodiac} женщина на {year}',
        7 => 'Любовный гороскоп {zodiac} {year}',
        8 => '{zodiac} мужчина {year}',
        9 => 'Гороскоп {zodiac} {year} год любовный',
        10 => 'Гороскоп на {year} {zodiac} мужчина',
        11 => 'Гороскоп {year_china2} {year} для {zodiac2}',
        12 => 'Год {year_china2} {year} гороскоп {zodiac}',
        13 => '{zodiac} {year_china} гороскоп на {year}',
        14 => 'Что ждет {zodiac3} в {year}',
        15 => '{zodiac} прогноз на {year}',
        16 => '{year} год для {zodiac2} женщины',
        17 => '{zodiac} прогноз на {year} год'
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