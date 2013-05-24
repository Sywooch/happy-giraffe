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
    public static function getByUserId($userId, $entity, $tagId)
    {
        $criteria = new CDbCriteria(array(
            'condition' => 'user_id = :user_id',
            'params' => array(':user_id' => $userId),
        ));

        if ($entity !== null) {
            $config = Yii::app()->controller->module->entities[$entity];
            $criteria->compare('entity', $config['class']);
            if (isset($config['criteria']))
                $criteria->mergeWith(new CDbCriteria($config['criteria']));
        }

        if ($tagId !== null) {
            $tagCriteria = new CDbCriteria(array(
                'with' => array(
                    'tags' => array(
                        'together' => true,
                    ),
                ),
                'condition' => 'tags.id = :tagId',
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
}
