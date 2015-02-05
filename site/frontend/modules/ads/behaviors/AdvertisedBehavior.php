<?php
/**
 * @author Никита
 * @date 05/02/15
 */

namespace site\frontend\modules\ads\behaviors;


abstract class AdvertisedBehavior extends \CActiveRecordBehavior
{
    public function afterSave()
    {

    }

    abstract public function getCreativeName();
    abstract public function getCreativeUrl();
}