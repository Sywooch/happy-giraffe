<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 9/1/13
 * Time: 10:49 PM
 * To change this template use File | Settings | File Templates.
 */

class SearchManager
{
    public static function getDataProvider($query, $type, $cuisine, $duration, $lowFat, $forDiabetics, $lowCal, $page)
    {
        $criteria = new CDbCriteria();

        if ($query != '')
            $criteria->mergeWith(self::getQueryCriteria($query));

        if ($type !== null)
            $criteria->compare('type', $type);

        if ($cuisine !== null)
            $criteria->compare('cuisine_id', $cuisine);

        if ($duration !== null) {
            if (CookRecipe::model()->durations[$duration]['min'] !== null)
                $criteria->compare('preparation_duration', '>=' . CookRecipe::model()->durations[$duration]['min']);
            if (CookRecipe::model()->durations[$duration]['max'] !== null)
                $criteria->compare('preparation_duration', '<' . CookRecipe::model()->durations[$duration]['max']);
        }

        if ($lowFat)
            $criteria->compare('lowFat', 1);

        if ($lowCal)
            $criteria->compare('lowCal', 1);

        if ($forDiabetics)
            $criteria->compare('forDiabetics', 1);

        return new CActiveDataProvider('CookRecipe', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
                'currentPage' => $page,
            ),
        ));
    }

    protected static function getQueryCriteria($query)
    {
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('title', $query);
        $criteria->addSearchCondition('text', $query, true, 'OR');
        return $criteria;
    }
}