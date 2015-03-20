<?php

namespace site\frontend\modules\photo\models\api;

/**
 * Description of Collection
 *
 * @author Кирилл
 */
class Collection extends \site\frontend\components\api\models\ApiModel
{

    public $api = 'photo/collections';

    /**
     * @param string $className
     * @return \site\frontend\modules\photo\models\api\Collection
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeNames()
    {
        return array(
            'id',
            'attachesCount',
            'cover',
            'updated',
        );
    }

}
