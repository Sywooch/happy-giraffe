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

    public function findAndModify ($param=array())
    {
        if (!array_key_exists('update',$param) AND !array_key_exists('remove',$param))  //one is required
        {return false;
        }

        $collection['findAndModify']=$this->getCollectionName();
        $param=array_merge($collection,$param);

        $result = $this->getDb()->command($param);
        $result["lastErrorObject"]["ok"]=1?$return= $result["value"]:$return= false;
        return $return;
    }
}
