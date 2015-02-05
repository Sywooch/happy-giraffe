<?php
namespace site\frontend\modules\ads\models;

/**
 * @author Никита
 * @date 05/02/15
 */

class Ad extends \HActiveRecord
{
    public function tableName()
    {
        return 'ads';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeCreate',
                'updateAttribute' => 'dtimeUpdate',
                'setUpdateOnCreate' => true,
            ),
        );
    }
}