<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 24/09/14
 * Time: 09:48 AM
 */

namespace site\frontend\modules\photo\components;


use site\frontend\modules\photo\models\PhotoAttach;

class UtilityHelper
{
    public static function moveBetweenCollections($sourceCollection, $destinationCollection, $attaches)
    {
        $criteria = new \CDbCriteria();
        $criteria->compare('t.collection_id', $sourceCollection);
        $criteria->addInCondition('t.id', $attaches);

        return PhotoAttach::model()->updateAll(array(
            'collection_id' => $destinationCollection,
        )) > 0;
    }

    public static function sortCollection($collection, $attaches)
    {
        foreach ($attaches as $i => $attachId) {
            PhotoAttach::model()->updateByPk($attachId, array('position' => $i));
        }
    }
} 