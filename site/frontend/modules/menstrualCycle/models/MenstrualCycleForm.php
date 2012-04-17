<?php

class MenstrualCycleForm extends CFormModel
{
    //day, month, year of cycle start
    public $day;
    public $month;
    public $year;

    public $cycle;
    public $critical_period;

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

    public $next_month;
    public $next_month_year;

    public function rules()
    {
        return array(
            array('day, month, year, cycle, critical_period', 'required', 'message'=>'Выберите из списка {attribute}'),
            array('review_month, review_year', 'safe'),
        );
    }

    public function AttributeLabels()
    {
        return array(
            'critical_period'=>'среднюю длительность вашей менструации',
            'cycle'=>'среднюю длительность вашего менструального цикла',
            'day'=>'день начала менструации предыдущего цикла',
            'month'=>'месяц, в котором началась менструация предыдущего цикла',
            'year'=>'год, в котором началась менструация предыдущего цикла',
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
                $this->critical_period = $user_cycle['menstruation'];
                return;
            }
        }
    }

    public function beforeValidate()
    {
        $this->start_date = strtotime($this->year . '-' . $this->month . '-' . $this->day);
        if (empty($this->review_month))
            $this->review_month = date('m');
        if (empty($this->review_year))
            $this->review_year = date('Y');

        return parent::beforeValidate();
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
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        return $model;
    }

    /**
     * Calculate data for current month
     *
     * @return array
     */
    public function CalculateData()
    {
        $this->model = $this->LoadModel($this->cycle, $this->critical_period);
        $data = $this->CalculateMonthData($this->review_month, $this->review_year);
        $this->model->SaveUserCycle($this->start_date);

        return $data;
    }

    /**
     * Calculate data for next month
     *
     * @return array
     */
    public function CalculateDataForNextMonth()
    {
        $this->next_month = $this->review_month + 1;
        $this->next_month_year = $this->review_year;
        if ($this->next_month == 13) {
            $this->next_month = 1;
            $this->next_month_year++;
        }
        $data = $this->CalculateMonthData($this->next_month, $this->next_month_year);

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
            'cell' => $this->model->GetPeriod($this->start_date, $day, $month, $year)
        );
    }
}