<?php
/**
 * @author Никита
 * @date 14/07/15
 */

class DailyStats
{
    public $nocache;

    public function __construct($nocache = false)
    {
        $this->nocache = $nocache;
    }


    public function getData()
    {
        $period = $this->getPeriod();

        if ($this->nocache) {
            $this->clearCache();
        }

        $data = array();
        foreach ($period as $dateObject) {
            $date = $dateObject->format('Y-m-d');

            $rowId = 'DailyStats.' . $date;
            $row = $this->getCacheComponent()->get($rowId);

            if ($row === false) {
                $row = array();
                $row['id'] = $date;
                $row['comments'] = $this->getCommentsCount($date);
                $row['users'] = $this->getRegisteredUsers($date);
                $row['posts'] = $this->getPosts($date);

                $diff = $dateObject->diff(new DateTime('tomorrow'));

                if ($diff->days > 0) {
                    $this->getCacheComponent()->set($rowId, $row);
                }
            }
            $data[] = $row;


        }

        return $data;
    }

    public function clearCache()
    {
        $period = $this->getPeriod();

        foreach ($period as $dateObject) {
            $date = $dateObject->format('Y-m-d');
            $rowId = 'DailyStats.' . $date;
            $this->getCacheComponent()->delete($rowId);
        }
    }

    protected function getPeriod()
    {
        return new DatePeriod(
            new DateTime('-1 month'),
            new DateInterval('P1D'),
            new DateTime('tomorrow')
        );
    }

    protected function getCommentsCount($date)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('DATE(created) = :date');
        $criteria->params = array(':date' => $date);

        return Comment::model()->count($criteria);
    }

    protected function getRegisteredUsers($date)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('DATE(register_date) = :date');
        $criteria->params = array(':date' => $date);

        return User::model()->count($criteria);
    }

    protected function getPosts($date)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('DATE(FROM_UNIXTIME(dtimeCreate)) = :date');
        $criteria->params = array(':date' => $date);

        return \site\frontend\modules\posts\models\Content::model()->count($criteria);
    }

    /**
     *
     * @return \CCache
     */
    protected static function getCacheComponent()
    {
        return \Yii::app()->getComponent('dbCache');
    }
}