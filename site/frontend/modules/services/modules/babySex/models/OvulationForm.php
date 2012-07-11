<?php

class OvulationForm extends CFormModel
{
    //day, month, year of cycle start
    public $day;
    public $month;
    public $year;

    public $con_day;
    public $con_month;
    public $con_year;

    public $cycle;

    /**
     * @var int mother born date
     */
    public $start_date;
    /**
     * @var MenstrualCycle
     */
    public $model;
    public $review_month;
    public $review_year;

    public function rules()
    {
        return array(
            array('day, month, year, cycle, con_day, con_month, con_year', 'required', 'message'=>'Выберите из списка {attribute}'),
            array('day, month, year, cycle, review_month, review_year, con_day, con_month, con_year', 'safe'),
        );
    }

    public function AttributeLabels()
    {
        return array(
            'cycle'=>'среднюю длительность своего менструального цикла',
            'day'=>'день начала последней менструации',
            'month'=>'месяц начала последней менструации',
            'year'=>'год начала последней менструации',
            'con_day'=>'день зачатия ребенка',
            'con_month'=>'месяц зачатия ребенка',
            'con_year'=>'год зачатия ребенка',
        );
    }

    public function init()
    {
        if (!Yii::app()->user->isGuest) {
            $user_cycle = MenstrualCycle::GetUserCycle(Yii::app()->user->id);
            if ($user_cycle !== null) {
                $this->day = date('j', strtotime($user_cycle['date']));
                $this->month = date('n', strtotime($user_cycle['date']));
                $this->year = date('Y', strtotime($user_cycle['date']));
                $this->cycle = $user_cycle['cycle'];
            }
        }
    }

    public function beforeValidate()
    {
        $this->start_date = strtotime(str_pad($this->day, 2, '0', STR_PAD_LEFT) . '-' . str_pad($this->month, 2, '0', STR_PAD_LEFT) . '-' . $this->year);
        if (empty($this->review_month))
            $this->review_month = date('m');
        if (empty($this->review_year))
            $this->review_year = date('Y');
    }

    /**
     * @param $cycle
     * @param $menstruation_duration
     * @return MenstrualCycle
     * @throws CHttpException
     */
    public function LoadModel($cycle, $menstruation_duration)
    {
        $model = MenstrualCycle::model()->cache(3600)->find('cycle=' . $cycle . ' AND menstruation=' . $menstruation_duration);
        if (empty($model))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.....');

        return $model;
    }

    /**
     * Calculate data for current month
     *
     * @return array
     */
    public function CalculateData()
    {
        $this->model = $this->LoadModel($this->cycle, 5);
        $data = $this->CalculateMonthData($this->review_month, $this->review_year);

        return $data;
    }

    private function CalculateMonthData($month, $year)
    {
        $data = array();

        $skip = date("w", mktime(0, 0, 0, $month, 1, $year)) - 1; // узнаем номер дня недели
        if ($skip < 0)
            $skip = 6;

        $daysInMonth = date("t", mktime(0, 0, 0, $month, 1, $year)); // узнаем число дней в месяце
        $day = 1; // для цикла далее будем увеличивать значение
        $num = 1;
        for ($i = 0; $i < 6; $i++) { // Внешний цикл для недель 6 с неполыми

            for ($j = 0; $j < 7; $j++) { // Внутренний цикл для дней недели

                if (($skip > 0) || ($day > $daysInMonth)) { // пустые ячейки до 1 го дня

                    $data[$num] = $this->GetDayData($day, $month, $year, $skip);
                    $skip--;

                }
                else {
                    $data[$num] = $this->GetDayData($day, $month, $year);
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
                $daysInMonth = date("t", mktime(0, 0, 0, $month, 1, $year)); // узнаем число дней в месяце
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
        return array(
            'day' => $day,
            'other_month' => $other_month,
            'sex' => $this->model->GetBabyGender($this->start_date, $day, $month, $year)
        );
    }

    public function GetGender()
    {
        $res =  $this->GetStrictDayData($this->con_day, $this->con_month, $this->con_year, false);
        return $res['sex'];
    }
}