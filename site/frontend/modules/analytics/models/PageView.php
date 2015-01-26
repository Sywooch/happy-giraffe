<?php
/**
 * @author Никита
 * @date 26/01/15
 */

namespace site\frontend\modules\analytics\models;


class PageView extends \EMongoDocument
{
    public $visits;
    public $updated;

    public function getCollectionName()
    {
        return 'views';
    }
} 