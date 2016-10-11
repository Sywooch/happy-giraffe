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

    public function run()
    {
        $data = $this->getData();
        $months = array_map(function($rowData, $key) {
            list($year, $month) = explode('-', $key);
            return new MonthRow($year, $month, $rowData);
        }, $data, array_keys($data));
        $this->render('stats', compact('months'));
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
        $group($months, $this->getAnswers(), 'nAnswers');
        $group($months, $this->getLikes(), 'nLikes');
        krsort($months);
        return $months;
    }

    protected function getAnswers()
    {
        $criteria = QaAnswer::model()->user($this->userId)->getDbCriteria();
        $criteria->select = new \CDbExpression('FROM_UNIXTIME(t.dtimeCreate, \'%Y-%m-%d\') date, COUNT(*) c');
        $criteria->group = 'date';
        return \Yii::app()->db->getCommandBuilder()->createFindCommand(QaAnswer::model()->tableName(), $criteria)->queryAll();
    }

    protected function getLikes()
    {
        $criteria = QaAnswer::model()->user($this->userId)->getDbCriteria();
        $criteria->select = new \CDbExpression('FROM_UNIXTIME(v.dtimeCreate, \'%Y-%m-%d\') date, COUNT(*) c');
        $criteria->join = 'JOIN qa__answers_votes v ON t.id = v.answerId';
        $criteria->group = 'date';
        return \Yii::app()->db->getCommandBuilder()->createFindCommand(QaAnswer::model()->tableName(), $criteria)->queryAll();
    }
}

class MonthRow
{
    public $year;
    public $month;
    public $days;

    public function __construct($year, $month, $data)
    {
        $this->year = $year;
        $this->month = $month;
        $nDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($i = 1; $i <= $nDays; $i++) {
            $day = [
                'nAnswers' => 0,
                'nLikes' => 0,
            ];
            if (isset($data[$i])) {
                $day = array_merge($day, $data[$i]);
            }
            $this->days[$i] = $day;
        }
    }
}