<?php

namespace site\frontend\modules\users\models;
\Yii::import('site.common.models.User', true);
/**
 * Description of User
 *
 * @author Кирилл
 */
class User extends \User
{
    private $_avatarObject;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('avatar', 'filter', 'filter' => array($this->avatarObject, 'serialize')),
        ));
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'birthday' => $this->birthday,
            'avatarId' => (int) $this->avatar_id,
            'gender' => (int) $this->gender,
            'isOnline' => (bool) $this->online,
            'profileUrl' => $this->getUrl(true),
            'publicChannel' => $this->getPublicChannel(),
        );
    }

    public function getAvatarObject()
    {
        if ($this->_avatarObject === null) {
            $this->_avatarObject = new UserAvatar($this->avatar, $this);
        }

        return $this->_avatarObject;
    }
}

?>
