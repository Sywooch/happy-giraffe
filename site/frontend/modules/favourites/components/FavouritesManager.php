<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 5/17/13
 * Time: 10:13 AM
 * To change this template use File | Settings | File Templates.
 */
class FavouritesManager
{
    public static function getByUserId($userId, $entity, $tagId, $query)
    {
        $criteria = new CDbCriteria(array(
            'condition' => 'user_id = :user_id',
            'params' => array(':user_id' => $userId),
        ));

        if ($entity !== null)
            $criteria->mergeWith(self::getEntityCriteria($entity));

        if ($tagId !== null) {
            $tagCriteria = new CDbCriteria(array(
                'join' => 'INNER JOIN favourites__tags_favourites tf ON tf.favourite_id = t.id AND tf.tag_id = :tagId',
                'params' => array(':tagId' => $tagId),
            ));
            $criteria->mergeWith($tagCriteria);
        }

        return new FavouritesDataProvider(array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }

    public static function getCountByUserId($userId, $entity = null)
    {
        $criteria = new CDbCriteria(array(
            'condition' => 'user_id = :user_id',
            'params' => array(':user_id' => $userId),
        ));

        if ($entity !== null)
            $criteria->mergeWith(self::getEntityCriteria($entity));

        return Favourite::model()->count($criteria);
    }

    protected static function getEntityCriteria($entity)
    {
        $criteria = new CDbCriteria();
        $config = Yii::app()->controller->module->entities[$entity];
        $criteria->compare('entity', $config['class']);
        if (isset($config['criteria']))
            $criteria->mergeWith(new CDbCriteria($config['criteria']));
        return $criteria;
    }
}
