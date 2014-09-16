<?php

namespace site\frontend\modules\users\models;

/**
 * Description of User
 *
 * @author Кирилл
 */
class User extends \User
{

    public function toJSON()
    {
        return array(
            'id' => $this->is,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'avatarId' => $this->avatar_id,
            'gender' => $this->gender,
            'isOnline' => $this->online,
            'profileUrl' => $this->getUrl(true),
            'publicChannel' => $this->getPublicChannel(),
        );
    }

}

?>
