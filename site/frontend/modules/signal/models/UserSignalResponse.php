<?php

class UserSignalResponse extends EMongoDocument
{
    const EXECUTE_LIMIT_TIME = 900;
    public $user_id;
    public $task_id;
    public $time;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'UserSignalResponse';
    }

    public function beforeSave()
    {
        $this->time = strtotime(date("Y-m-d H:i:s") );
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
        $criteria->addCond('time', '<', strtotime(date("Y-m-d H:i:s") )- self::EXECUTE_LIMIT_TIME);

        $models = self::model()->findAll($criteria);
        foreach($models as $model){
            $signal = UserSignal::model()->findByPk(new MongoId($model->task_id));
            if (in_array($model->user_id, $signal->executors)){
                $signal->DeclineExecutor($model->user_id);
                //UserSignal::SendUpdateSignal($model->user_id);
            }
            $model->delete();
        }
    }
}
