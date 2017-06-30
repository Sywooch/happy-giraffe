<?php

namespace site\frontend\modules\iframe\models;

class UsersList extends \site\frontend\modules\users\models\User
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

     public function relations()
     {
        $relations = parent::relations();
        $relations['rating'] = [self::HAS_ONE, 'site\frontend\modules\som\modules\qa\models\QaRating', 'user_id', 'on' => 'category_id = ' . QaCategory::PEDIATRICIAN_ID];
        return $relations;
     }

    public function getCity()
    {
        return isset($this->address->city->name) ? $this->address->city->name : '';
    }

    /**
     * Изменение url для iframe модуля
     * @inheritdoc
     */
    protected function getProfileUrl()
    {
        return \Yii::app()->createUrl('/iframe/userProfile/default/index',['userId'=>$this->id]);
    }
}
