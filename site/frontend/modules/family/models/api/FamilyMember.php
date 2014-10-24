<?php
/**
 * @author Никита
 * @date 24/10/14
 */

namespace site\frontend\modules\family\models\api;

class FamilyMember extends \site\frontend\components\api\models\ApiModel
{
    public $api = 'family';

    public function attributeNames()
    {
        return array(
            'name',
            'gender',
            'birthday',
            'userId',
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function actionAttributes()
    {
        return array(
            'insert' => false,
            'update' => $this->attributeNames(),
            'remove' => false,
            'restore' => false,
        );
    }
    
    public function setByUser(\User $user)
    {
        $this->gender = $user->gender;
        $this->birthday = $user->birthday;
        $this->name = $user->first_name;
        $this->userId = $user->id;   
    }
} 