<?php

class UserSignalResponse extends EMongoDocument
{
    const STATUS_OPEN = 1;
    const STATUS_SUCCESS_CLOSE = 2;
    const STATUS_FAIL_CLOSE = 3;

    const EXECUTE_LIMIT_TIME = 900;
    public $user_id;
    public $task_id;
    public $date;
    public $time;

    public $status = self::STATUS_OPEN;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'user_signal_response';
    }

    public function beforeSave()
    {
        $this->time = time();
        $this->date = date("Y-m-d");
        return parent::beforeSave();
    }

    /**
     * @static
     * Если модератор за 15 имнут не выполнил задание, отменяем его.
     *
     * Запускать раз в 5 минут
     */
    public static function CheckLate()
    {
        $criteria = new EMongoCriteria;
        $criteria->addCond('time', '<', time()- self::EXECUTE_LIMIT_TIME);
        $criteria->addCond('status', '==', self::STATUS_OPEN);

        $models = self::model()->findAll($criteria);
        foreach($models as $model){
            $signal = UserSignal::model()->findByPk(new MongoId($model->task_id));
            if (!empty($signal->executors))
                if (in_array($model->user_id, $signal->executors)){
                    $signal->DeclineExecutor($model->user_id);
                }
            $model->status = self::STATUS_FAIL_CLOSE;
            $model->save();
        }
    }

    public static function Decline($signal, $user_id)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$user_id);
        $criteria->task_id('==', $signal->_id);
        $criteria->status('==', self::STATUS_OPEN);

        $model = self::model()->find($criteria);
        if ($model === null){
            Yii::log('fail when search signal response 1');
            return ;
        }
        $model->status = self::STATUS_FAIL_CLOSE;
        $model->save();
    }

    public static function TaskSuccess($signal, $user_id){
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$user_id);
        $criteria->task_id('==', $signal->_id);
        $criteria->status('==', self::STATUS_OPEN);

        $model = self::model()->find($criteria);
        if ($model === null){
            Yii::log('fail when search signal response 2');
            return ;
        }
        $model->status = self::STATUS_SUCCESS_CLOSE;
        $model->save();
    }

    public function signal(){
        return UserSignal::model()->findByPk(new MongoId($this->task_id));
    }
}
