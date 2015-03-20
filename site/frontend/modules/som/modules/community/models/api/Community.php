<?php

namespace \site\frontend\modules\som\modules\community\models\api;

/**
 * Description of Community
 *
 * @author Кирилл
 */
class Community extends \site\frontend\components\api\models\ApiModel
{

    public $api = 'community';

    /**
     * @param string $className
     * @return \site\frontend\modules\som\modules\community\models\api\Community
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeNames()
    {
        
    }

}
