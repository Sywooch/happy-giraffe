<?php

class UserSignalResponse extends EMongoDocument
{
    const EXECUTE_LIMIT_TIME = 900;
    public $user_id;
    public $task_id;
    public $time;

    public $status = 0;

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
        $criteria->addCond('status', '==', 0);

        $models = self::model()->findAll($criteria);
        foreach($models as $model){
            $signal = UserSignal::model()->findByPk(new MongoId($model->task_id));
            if (in_array($model->user_id, $signal->executors)){
                $signal->DeclineExecutor($model->user_id);
            }
            $model->status = 1;
            $model->save();
        }
    }

    public function signal(){
        return UserSignal::model()->findByPk(new MongoId($this->task_id));
    }
}
