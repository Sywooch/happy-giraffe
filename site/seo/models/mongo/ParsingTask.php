<?php
/**
 * Author: alexk984
 * Date: 10.04.12
 */
class ParsingTask extends EMongoDocument
{
    const TYPE_SIMPLE = 0;
    const TYPE_CHECK_BAD_KEYWORD = 1;

    public $keyword_id;
    public $type = self::TYPE_SIMPLE;
    public $active = 0;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'parsing_task';
    }

    public static function add($keyword_id, $type)
    {
        $params = array(
            'keyword_id' => (int)$keyword_id,
            'type' => (int)$type,
        );

        self::model()->getCollection()->insert($params);
    }
}