<?php
/**
 * @author Никита
 * @date 21/04/15
 */

namespace site\frontend\modules\posts\modules\myGiraffe\components;


use site\frontend\modules\posts\models\Content;

class DataProvider extends \CActiveDataProvider
{
    protected function fetchData()
    {
        $feedItems = parent::fetchData();
        $ids = array_map(function($item) {
            return $item->postId;
        }, $feedItems);
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('id', $ids);
        $contents = Content::model()->findAll($criteria);

        usort($contents, function($a, $b) use ($ids) {
            return array_search($a->id, $ids) > array_search($b->id, $ids);
        });

        return $contents;
    }
}