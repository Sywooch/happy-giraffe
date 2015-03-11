<?php

namespace site\frontend\modules\som\modules\activity\models\api;

/**
 * Description of Activity
 *
 * @property int $userId
 * @property string $typeId
 * @property int $dtimeCreate
 * @property array $data
 * 
 * @author Кирилл
 */
class Activity extends \site\frontend\components\api\models\ApiModel
{

    public $api = 'activity';

    /**
     * @param string $className
     * @return \site\frontend\modules\posts\models\api\Content
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeNames()
    {
        return array(
            'id',
            'userId',
            'typeId',
            'dtimeCreate',
            'data',
            'hash',
        );
    }

    public function actionAttributes()
    {
        return array(
            'insert' => array(
                'userId',
                'typeId',
                'dtimeCreate',
                'data',
                'hash',
            ),
        );
    }

}
