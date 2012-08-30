<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
abstract class PostForCommentator
{
    protected static function getCriteria($users = true)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = self::generateTimeCondition();
        $criteria->with = array(
            'author' => array(
                'condition' => $users ? 'author.group = 0' : 'author.group > 0',
                'together' => true,
            )
        );
        $criteria->order = 'rand()';

        return $criteria;
    }

    protected static function getSimpleCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = self::generateSimpleTimeCondition();
        $criteria->order = 'rand()';

        return $criteria;
    }

    protected static function generateTimeCondition()
    {
        $rand = rand(0, 99);
        if ($rand < 30)
            return 'created >= "' . date("Y-m-d H:i:s", strtotime('-1 hour')) . '"';
        elseif ($rand < 50)
            return 'created >= "' . date("Y-m-d H:i:s", strtotime('-3 hour')) . '" AND created < "' . date("Y-m-d H:i:s", strtotime('-1 hour')) . '"';
        elseif ($rand < 70)
            return 'created >= "' . date("Y-m-d H:i:s", strtotime('-6 hour')) . '" AND created < "' . date("Y-m-d H:i:s", strtotime('-3 hour')) . '"';
        elseif ($rand < 90)
            return 'created >= "' . date("Y-m-d H:i:s", strtotime('-18 hour')) . '" AND created < "' . date("Y-m-d H:i:s", strtotime('-6 hour')) . '"';
        else
            return 'created >= "' . date("Y-m-d H:i:s", strtotime('-144 hour')) . '" AND created < "' . date("Y-m-d H:i:s", strtotime('-18 hour')) . '"';
    }

    protected static function generateSimpleTimeCondition()
    {
        $rand = rand(0, 99);
        if ($rand < 90)
            return 'created >= "' . date("Y-m-d ") . ' 00:00:00"';
        else
            return 'created >= "' . date("Y-m-d H:i:s", strtotime('-144 hour')) . '" AND created < "' . date("Y-m-d H:i:s") . ' 00:00:00"';
    }

    protected static function maxTimeCondition()
    {
        return 'created >= "' . date("Y-m-d H:i:s", strtotime('-144 hour')) . '"';
    }

    public static function recentlyCommented($entity, $entity_id)
    {
        $res = Yii::app()->db->createCommand()
            ->select('id')
            ->from('comments')
            ->where('entity = :entity AND entity_id = :entity_id AND author_id = :author_id AND created > :created', array(
            'entity' => $entity,
            'entity_id' => $entity_id,
            'author_id' => Yii::app()->user->id,
            'created' => date("Y-m-d H:i:s", strtotime('-1 hour')),
        ))
            ->queryColumn();
        if (empty($res))
            return false;

        return true;
    }
}
