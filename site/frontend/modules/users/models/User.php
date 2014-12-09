<?php

namespace site\frontend\modules\users\models;
\Yii::import('site.common.models.User');
/**
 * Description of User
 *
 * @author Кирилл
 */
class User extends \fUser
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'avatarId' => (int) $this->avatar_id,
            'gender' => (int) $this->gender,
            'isOnline' => (bool) $this->online,
            'profileUrl' => $this->getUrl(true),
            'publicChannel' => $this->getPublicChannel(),
        );
    }

}

?>
