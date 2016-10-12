<?php
/**
 * @author Никита
 * @date 11/10/16
 */

namespace site\frontend\modules\specialists\modules\pediatrician\widgets\stats;


use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;

class StatsWidget extends \CWidget
{
    public $userId;

    protected $answers;
    protected $likes;

    public function init()
    {
        $this->answers = $this->getAnswers();
        $this->likes = $this->getLikes();
    }

    public function run()
    {
        $data = $this->getData();
        if ($data) {
            $months = [];
            foreach ($data as $k => $v) {
                list($year, $month) = explode('-', $k);
                $nDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $monthData = [];
                for ($i = 1; $i <= $nDays; $i++) {
                    $date = $year . '-' . $month . '-' . sprintf("%02d", $i);;
                    if ($this->dateIsValid($date)) {
                        $monthData[$i] = array_merge([
                            'nAnswers' => 0,
                            'nLikes' => 0,
                        ], (isset($data[$k][$i])) ? $data[$k][$i] : []);
                    } else {
                        $monthData[$i] = null;
                    }
                }
                $months[] = new MonthRow($year, $month, $monthData);

            }
            $this->render('stats', compact('months'));
        } else {
            $this->render('empty');
        }
    }

    protected function dateIsValid($date)
    {
        $firstAnswer = array_pop(array_slice($this->answers, -1))['date'];
        return $date >= $firstAnswer && $date <= date('Y-m-d');
    }

    protected function getData()
    {
        $months = [];
        $group = function(&$months, $data, $key) {
            foreach ($data as $row) {
                list($year, $month, $day) = explode('-', $row['date']);
                $monthId = $year . '-' . $month;
                if (! isset($months[$monthId])) {
                    $months[$monthId] = [];
                }
                if (! isset($months[$monthId][$day])) {
                    $months[$monthId][$day] = [];
                }
                $months[$monthId][$day][$key] = $row['c'];
            }
        };
        $group($months, $this->answers, 'nAnswers');
        $group($months, $this->likes, 'nLikes');
        return $months;
    }

    protected function getAnswers()
    {
        $criteria = QaAnswer::model()->user($this->userId)->getDbCriteria();
        $criteria->select = new \CDbExpression('FROM_UNIXTIME(t.dtimeCreate, \'%Y-%m-%d\') date, COUNT(*) c');
        $criteria->group = 'date';
        $criteria->order = 'date DESC';
        return \Yii::app()->db->getCommandBuilder()->createFindCommand(QaAnswer::model()->tableName(), $criteria)->queryAll();
    }

    protected function getLikes()
    {
        $criteria = QaAnswer::model()->user($this->userId)->getDbCriteria();
        $criteria->select = new \CDbExpression('FROM_UNIXTIME(v.dtimeCreate, \'%Y-%m-%d\') date, COUNT(*) c');
        $criteria->join = 'JOIN qa__answers_votes v ON t.id = v.answerId';
        $criteria->group = 'date';
        $criteria->order = 'date DESC';
        return \Yii::app()->db->getCommandBuilder()->createFindCommand(QaAnswer::model()->tableName(), $criteria)->queryAll();
    }
}

class MonthRow
{
    public $year;
    public $month;
    public $days;

    public function __construct($year, $month, $days)
    {
        $this->year = $year;
        $this->month = $month;
        $this->days = $days;
    }
}