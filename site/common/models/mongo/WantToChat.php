<?php
/**
 * Author: choo
 * Date: 15.05.2012
 */
class WantToChat extends EMongoDocument
{
    const CHAT_DURATION = 43200; //12 часов
    const CHAT_COOLDOWN = 604800; //7 дней

    public $user_id;
    public $created;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'want_to_chat';
    }

    public static function getList($limit = null)
    {
        $criteria = new EMongoCriteria;
        $criteria->created('>', time() - self::CHAT_DURATION);
        $models = self::model()->findAll($criteria);

        $modelsIds = array();
        foreach ($models as $w) {
            $modelsIds[] = $w->user_id;
        }

        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $modelsIds);
        $criteria->order = 'RAND()';
        $criteria->limit = $limit;
        return User::model()->findAll($criteria);
    }

    public static function hasCooldown($user_id)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id = (int) $user_id;
        $criteria->created('>', time() - self::CHAT_COOLDOWN);

        return self::model()->find($criteria) !== null;
    }
}
