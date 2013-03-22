<?php
class ParsingQueue extends EMongoDocument
{
    public $active = 0;

    public function getCollectionName()
    {
        return 'parsing_queue';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getKeyword()
    {

    }

    public function addKeyword($keyword_id)
    {
        $m = new self;
        $m->_id = $keyword_id;
        $m->save();
    }
}
