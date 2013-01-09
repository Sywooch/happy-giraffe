<?php
/**
 * Author: alexk984
 * Date: 08.01.13
 */

class UserRegister extends EMongoDocument
{
    public $user_id;
    public $register_type;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'user_register';
    }

    public static function create($user_id)
    {
        $type = Yii::app()->user->getState('register_type', 'default');
        $model = new UserRegister;
        $model->user_id = (int)$user_id;
        $model->register_type = $type;
        $model->save();
    }

    /**
     * @param $users User[]
     * @return array
     */
    public static function getCountByType($users)
    {
        $criteria = new EMongoCriteria();
        $user_ids = array();
        foreach ($users as $user)
            $user_ids[] = (int)$user->id;
        $criteria->addCond('user_id', 'in', $user_ids);

        $models = self::model()->findAll($criteria);

        $result = array(
            'default' => 0,
            'horoscope' => 0,
            'pregnancy' => 0,
        );
        foreach ($models as $model)
            $result[$model->register_type]++;

        return $result;
    }
}