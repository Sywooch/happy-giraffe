<?php
/**
 * Author: alexk984
 * Date: 10.04.12
 */
class ParseHelper extends EMongoDocument
{
    public $line;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'parse_helper';
    }

    public static function getLine()
    {
        $model = ParseHelper::model()->find();
        if ($model === null){
            $model = new ParseHelper;
            $model->line = 900000;
            $model->save();
        }

        return $model->line;
    }

    public static function setLine($n)
    {
        $model = ParseHelper::model()->find();
        if ($model === null){
            $model = new ParseHelper;
        }
        $model->line = $n;
        $model->save();
    }
}