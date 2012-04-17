<?php

class UserSignalHistory extends EMongoDocument
{
    public $user_id;
    public $date;
    public $numberTaskSuccess = 0;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'user_signals_history';
    }

    /**
     * @return null|User
     */
    public function getUser()
    {
        if (!empty($this->user_id))
            return User::getUserById($this->user_id);
        return null;
    }

    /**
     * @param UserSignal $signal
     */
    public static function TaskSuccess($signal, $user_id){
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$user_id);
        $criteria->date('==', $signal->created);

        $model = self::model()->find($criteria);
        if ($model === null){
            $model = new UserSignalHistory();
            $model->date = $signal->created;
            $model->user_id = (int)$user_id;
        }
        $model->numberTaskSuccess++;
        $model->save();
    }

    /**
     * @param int $month
     * @return array
     */
    public static function getCalendarData($year, $month)
    {
        $data = array();
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)Yii::app()->user->id);
        $criteria->date =  new MongoRegex('/'.$year.'-'.$month.'/');

        $models = self::model()->findAll($criteria);
        foreach($models as $model){
            $day = date('j', strtotime($model->date));
            $data[$day] = CHtml::link($day, '');
        }

        return $data;
    }
}
