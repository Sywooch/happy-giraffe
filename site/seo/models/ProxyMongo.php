<?php
/**
 * Author: alexk984
 * Date: 26.08.12
 */
class ProxyMongo extends EMongoDocument
{
    public $value;
    public $active = 0;
    public $rank;
    public $created;

    public function getCollectionName()
    {
        return 'proxy';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function afterSave()
    {
        if ($this->isNewRecord)
            $this->created = time();

        parent::afterSave();
    }
}
