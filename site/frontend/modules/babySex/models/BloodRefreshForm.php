<?php

class BloodRefreshForm extends CFormModel
{
    const IS_UNKNOWN = 0;
    const IS_BOY = 1;
    const IS_GIRL = 2;

    const WOMAN_PERIOD = 91.3125;
    const MAN_PERIOD = 121.75;

    //day, month, year of mother born
    public $mother_d;
    public $mother_m;
    public $mother_y;

    //day, month, year of father born
    public $father_d;
    public $father_m;
    public $father_y;

    //day, month, year of baby conception
    public $baby_d;
    public $baby_m;
    public $baby_y;

    /**
     * @var int mother born date
     */
    public $mother_born_date;
    /**
     * @var int father born date
     */
    public $father_born_date;
    /**
     * @var int baby conception date
     */
    public $baby_born_date;

    public $review_month;
    public $review_year;

    public function rules()
    {
        return array(
            array('mother_d, mother_m, mother_y, father_d, father_m, father_y, baby_d, baby_m, baby_y', 'required'),
            array('review_month, review_year', 'safe'),
//            array('mother_m, father_m, baby_m', 'numerical', 'integerOnly' => true, 'max' => 12, 'min' => 1),
//            array('mother_d, father_d, baby_d', 'numerical', 'integerOnly' => true, 'max' => 31, 'min' => 1),
//            array('mother_y, father_y, baby_y', 'numerical', 'integerOnly' => true, 'max' => 2030, 'min' => 1900),
        );
    }

    public function beforeValidate()
    {
        $this->mother_born_date = strtotime($this->mother_d . '-' . $this->mother_m . '-' . $this->mother_y);
        $this->father_born_date = strtotime($this->father_d . '-' . $this->father_m . '-' . $this->father_y);
        $this->baby_born_date = strtotime($this->baby_d . '-' . $this->baby_m . '-' . $this->baby_y);

        if (empty($this->review_month))
            $this->review_month = $this->baby_m;
        if (empty($this->review_year))
            $this->review_year = $this->baby_y;

        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        if ($this->hasErrors('father_d') || $this->hasErrors('father_m') || $this->hasErrors('father_y'))
            $this->addError('father_born_date', 'Укажите дату рождения отца полностью');

        if ($this->hasErrors('mother_d') || $this->hasErrors('mother_m') || $this->hasErrors('mother_y'))
            $this->addError('mother_born_date', 'Укажите дату рождения матери полностью');

        if ($this->hasErrors('baby_d') || $this->hasErrors('baby_m') || $this->hasErrors('baby_y'))
            $this->addError('baby_born_date', 'Укажите дату зачатия ребенка полностью');

        parent::afterValidate();
    }

    /**
     * Calculate data for baby conception month
     * Result array include arrays like
     * array(
     *     day => 2
     *     who => 1 (boy)
     *     probability => 69 (%)
     *     other_month => false
     * )
     *
     * @return array
     */
    public function CalculateMonthData()
    {
        $data = array();

        $skip = date("w", mktime(0, 0, 0, (int)$this->review_month, 1, (int)$this->review_year)) - 1; // узнаем номер дня недели
        if ($skip < 0)
            $skip = 6;

        $daysInMonth = date("t", mktime(0, 0, 0, (int)$this->review_month, 1, (int)$this->review_year)); // узнаем число дней в месяце
        $day = 1; // для цикла далее будем увеличивать значение
        $num = 1;
        for ($i = 0; $i < 6; $i++) { // Внешний цикл для недель 6 с неполыми

            for ($j = 0; $j < 7; $j++) { // Внутренний цикл для дней недели

                if (($skip > 0) || ($day > $daysInMonth)) { // пустые ячейки до 1 го дня

                    $data[$num] = $this->GetDayData($day, $this->review_month, $this->review_year, $skip);
                    $skip--;

                }
                else {
                    $data[$num] = $this->GetDayData($day, $this->review_month, $this->review_year);
                    $day++; // увеличиваем $day
                }
                $num++;
            }

            if ($day > $daysInMonth)
                break;
        }

        return $data;
    }

    /**
     * Get array with data on current day with skip days
     *
     * @param $day
     * @param $month
     * @param $year
     * @param null $skip
     * @return array
     */
    private function GetDayData($day, $month, $year, $skip = null)
    {
        if ($skip !== null) {
            if ($day == 1) {
                //set month to previous
                $month--;
                if ($month == 0) {
                    $month = 12;
                    $year--;
                }
                $daysInMonth = date("t", mktime(0, 0, 0, (int)$month, 1, (int)$year)); // узнаем число дней в месяце
                $day = $daysInMonth - $skip + 1;
            } else {
                //set month to next
                $month++;
                if ($month == 13) {
                    $month = 1;
                    $year++;
                }
                $day = 1 - $skip;
            }
            return $this->GetStrictDayData($day, $month, $year, true);
        }

        return $this->GetStrictDayData($day, $month, $year, false);
    }

    /**
     * Get array with data on current day
     *
     * @param $day
     * @param $month
     * @param $year
     * @param $other_month
     * @return array
     */
    private function GetStrictDayData($day, $month, $year, $other_month)
    {
        $mother_blood_age = $this->GetMotherBloodAge(strtotime($day . '-' . $month . '-' . $year));
        $father_blood_age = $this->GetFatherBloodAge(strtotime($day . '-' . $month . '-' . $year));

        if ($mother_blood_age >= $father_blood_age) {
            $probability = round(($mother_blood_age - $father_blood_age) * 100);
            $sex = self::IS_BOY;
        } else {
            $probability = round(($father_blood_age - $mother_blood_age) * 100);
            $sex = self::IS_GIRL;
        }
        if ($probability == 0)
            $sex = self::IS_UNKNOWN;

        return array(
            'day' => $day,
            'sex' => $sex,
            'probability' => round($probability /2 + 50),
            'other_month' => $other_month,
            'opacity' => self::Opacity($probability)
        );
    }

    /**
     * Mother blood age on current date
     *
     * @param $date
     * @return float
     */
    private function GetMotherBloodAge($date)
    {
        return round(fmod(($date - $this->mother_born_date) / (60 * 60 * 24), self::WOMAN_PERIOD)) / self::WOMAN_PERIOD;
    }

    /**
     * Father blood age on current date
     *
     * @param $date
     * @return float
     */
    private function GetFatherBloodAge($date)
    {
        return round(fmod(($date - $this->father_born_date) / (60 * 60 * 24), self::MAN_PERIOD)) / self::MAN_PERIOD;
    }

    private static function Opacity($prc)
    {
        $opacity = round((abs($prc/2 + 50)) / 20) * 20;
        return $opacity;
    }

    public function GetGender()
    {
        $mother_blood_age = $this->GetMotherBloodAge(strtotime($this->baby_d. '-' . $this->baby_m. '-' . $this->baby_y));
        $father_blood_age = $this->GetFatherBloodAge(strtotime($this->baby_d. '-' . $this->baby_m. '-' . $this->baby_y));

        if ($mother_blood_age >= $father_blood_age) {
            $probability = 50 + round(($mother_blood_age - $father_blood_age) * 50);
            $sex = self::IS_BOY;
        } else {
            $probability = 50 + round(($father_blood_age - $mother_blood_age) * 50);
            $sex = self::IS_GIRL;
        }
        if ($probability == 50)
            $sex = self::IS_UNKNOWN;
        return $sex;
    }
}