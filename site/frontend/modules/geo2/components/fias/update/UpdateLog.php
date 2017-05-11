<?php
/**
 * @author Никита
 * @date 02/03/17
 */

namespace site\frontend\modules\geo2\components\fias\update;


class UpdateLog extends \EMongoDocument
{
    public $created;
    public $version;

    public function getCollectionName()
    {
        return 'fias_update_log';
    }
    
    public function orderDesc()
    {
        $this->getDbCriteria()->sort('created', \EMongoCriteria::SORT_DESC);
        return $this;
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}