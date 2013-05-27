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
    const FAVOURITES_PER_PAGE = 15;

    public static function getByUserId($userId, $entity = null, $tagId = null, $query = null, $offset = null)
    {
        $criteria = self::getCriteria($userId, $entity, $tagId, $query);
        $criteria->offset = $offset;
        $criteria->limit = self::FAVOURITES_PER_PAGE;

        $favourites = Favourite::model()->findAll($criteria);

        //получение необходимых id для выборки
        $entities = array();
        foreach ($favourites as $favourite)
            $entities[$favourite->model_name][$favourite->model_id] = null;

        //выборка и создание моделей
        foreach ($entities as $entity => $ids) {
            $criteria = new CDbCriteria(array(
                'index' => 'id',
            ));
            $criteria->addInCondition('t.id', array_keys($ids));
            if (isset(Yii::app()->controller->module->relatedModelCriteria[$entity]))
                $criteria->mergeWith(new CDbCriteria(Yii::app()->controller->module->relatedModelCriteria[$entity]));
            $models = CActiveRecord::model($entity)->findAll($criteria);
            foreach ($models as $m)
                $entities[$entity][$m->id] = $m;
        }

        //присваивание моделей соответсвующим элементам избранного
        foreach ($favourites as $favourite)
            $favourite->relatedModel = $entities[$favourite->model_name][$favourite->model_id];

        return $favourites;
    }

    public static function getCountByUserId($userId, $entity = null, $tagId = null, $query = null)
    {
        return Favourite::model()->count(self::getCriteria($userId, $entity, $tagId, $query));
    }

    protected static function getCriteria($userId, $entity, $tagId, $query)
    {
        $criteria = new CDbCriteria(array(
            'condition' => 'user_id = :user_id',
            'params' => array(':user_id' => $userId),
            'order' => 't.id DESC',
        ));

        if ($entity !== null)
            $criteria->compare('t.entity', $entity);

        if ($tagId !== null) {
            $tagCriteria = new CDbCriteria(array(
                'join' => 'INNER JOIN favourites__tags_favourites tf ON tf.favourite_id = t.id AND tf.tag_id = :tagId',
                'params' => array(':tagId' => $tagId),
            ));
            $criteria->mergeWith($tagCriteria);
        }

        return $criteria;
    }
}
