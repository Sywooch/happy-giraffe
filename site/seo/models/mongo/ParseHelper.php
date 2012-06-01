<?php
/**
 * Author: alexk984
 * Date: 10.04.12
 */
class ParseHelper extends EMongoDocument
{
    public $line;
    public $thread;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'parse_helper';
    }

    public static function getLine($thread)
    {
        $criteria = new EMongoCriteria;
        $criteria->thread('==', (int)$thread);
        $model = ParseHelper::model()->find($criteria);
        if ($model === null) {
            $model = new ParseHelper;
            $model->thread = (int)$thread;
            $model->line = 6000000 + $thread * 4000000;
            $model->save();
        }

        return $model->line;
    }

    public static function setLine($thread, $n)
    {
        $criteria = new EMongoCriteria;
        $criteria->thread('==', (int)$thread);
        $model = ParseHelper::model()->find($criteria);
        if ($model === null) {
            $model = new ParseHelper;
            $model->thread = (int)$thread;
        }
        $model->line = $n;
        $model->save();
    }
}