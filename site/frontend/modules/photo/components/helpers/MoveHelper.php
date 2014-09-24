<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 24/09/14
 * Time: 09:25 AM
 */

namespace site\frontend\modules\photo\components\helpers;

use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

class MoveHelper
{
    public static function betweenCollections($sourceCollection, $destinationCollection, $attaches)
    {
        $criteria = new \CDbCriteria();
        $criteria->compare('t.collection_id', $sourceCollection);
        $criteria->addInCondition('t.id', $attaches);

        PhotoAttach::model()->updateAll(array(
            'collection_id' => $destinationCollection,
        ));
    }
} 