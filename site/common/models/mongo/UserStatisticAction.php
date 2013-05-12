<?php
/**
 * Действия пользователя важные для статистики
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class UserStatisticAction
{
    const TYPE_LOAD_AVATAR = 0;

    /**
     * @return MongoCollection
     */
    public static function getCollection()
    {
        $connection = Yii::app()->getComponent('mongodb')->getConnection();
        return $connection->selectCollection('happy_giraffe_db', 'user_statistic_actions');
    }

    /**
     * @param $user_id
     */
    public static function avatarLoaded($user_id)
    {
        $collection = self::getCollection();
        $collection->ensureIndex(array('type' => 1, 'created' => 1), array('name' => 'type'));
        $collection->insert(array(
            'type' => self::TYPE_LOAD_AVATAR,
            'user_id' => (int)$user_id,
            'created' => time(),
        ));
    }
}