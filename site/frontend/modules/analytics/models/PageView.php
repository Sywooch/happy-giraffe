<?php
/**
 * @author Никита
 * @date 26/01/15
 */

namespace site\frontend\modules\analytics\models;


class PageView extends \EMongoDocument
{
    public $visits = 0;
    public $created;
    public $updated;

    public function getCollectionName()
    {
        return 'views';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'timestampBehavior' => array(
                'class' => '\site\common\behaviors\HMongoTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            )
        );
    }
} 