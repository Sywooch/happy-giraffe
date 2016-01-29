<?php
/**
 * @author Никита
 * @date 13/10/15
 */

namespace site\frontend\modules\som\modules\community\models\api;


class CommunityClub extends \site\frontend\components\api\models\ApiModel
{
    public $api = 'community';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeNames()
    {
        return array(
            'id',
            'title',
            'url',
        );
    }

    public static function getClub($labels)
    {
        return self::model()->query('getClub', array('labels' => $labels));
    }
}