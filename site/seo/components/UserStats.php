<?php
/**
 * Author: alexk984
 * Date: 13.07.12
 */

class UserStats
{
    public static function regCount($date)
    {
        return Yii::app()->db->createCommand('select count(id) from users where register_date >= "' . $date . ' 00:00:00" AND register_date <= "' . $date . ' 23:59:59";')->queryScalar();
    }

    public static function contentsCriteria($date, $group)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'author'=>array(
                'condition' => 'author.group = '.$group
            )
        );
        $criteria->condition = 'created >= "' . $date . ' 00:00:00" AND created <= "' . $date . ' 23:59:59"';
        $criteria->compare('removed', 0);
        return $criteria;
    }

    /*************** CLUB ******************/
    public static function clubPostCount($date, $group)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('type_id', 1);
        $criteria->mergeWith(self::clubContentsCriteria($date, $group));
        return CommunityContent::model()->count($criteria);
    }

    public static function clubVideoCount($date, $group)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('type_id', 2);
        $criteria->mergeWith(self::clubContentsCriteria($date, $group));
        return CommunityContent::model()->count($criteria);
    }

    public static function clubContentsCriteria($date, $group)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'rubric.user_id IS NULL'
            ),
        );
        $criteria->mergeWith(self::contentsCriteria($date, $group));
        return $criteria;
    }

    public static function clubCommentsCount($date, $group)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'author'=>array(
                'condition' => 'author.group = '.$group
            )
        );
        $criteria->condition = 'created >= "' . $date . ' 00:00:00" AND created <= "' . $date . ' 23:59:59"';
        $criteria->compare('entity', 'CommunityContent');
        $criteria->compare('removed', 0);
        return Comment::model()->count($criteria);
    }


    /*************** BLOG ******************/
    public static function blogContentsCriteria($date, $group)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'rubric.user_id IS NOT NULL'
            ),
        );
        $criteria->mergeWith(self::contentsCriteria($date, $group));
        return $criteria;
    }

    public static function blogPostCount($date, $group)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('type_id', 1);
        $criteria->mergeWith(self::blogContentsCriteria($date, $group));
        return CommunityContent::model()->count($criteria);
    }

    public static function blogVideoCount($date, $group)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('type_id', 2);
        $criteria->mergeWith(self::blogContentsCriteria($date, $group));
        return CommunityContent::model()->count($criteria);
    }

    public static function blogCommentsCount($date, $group)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'author'=>array(
                'condition' => 'author.group = '.$group
            )
        );
        $criteria->condition = 'created >= "' . $date . ' 00:00:00" AND created <= "' . $date . ' 23:59:59"';
        $criteria->compare('entity', 'BlogContent');
        $criteria->compare('removed', 0);
        return Comment::model()->count($criteria);
    }

    /*************** SERVICE ******************/

}