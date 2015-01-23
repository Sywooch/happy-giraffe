<?php

namespace site\frontend\components;

/**
 * Description of AuthManager
 *
 * @author Кирилл
 */
class AuthManager extends \CDbAuthManager
{

    public $authFile = false;
    public $defaultRoles = array('guest');
    public $assignmentTable = 'newauth__assignments';
    public $itemTable = 'newauth__items';
    public $itemChildTable = 'newauth__items_childs';

    public function __construct()
    {
        $this->authFile = \Yii::getPathOfAlias('site.frontend.config') . '/newAuth.php';
    }

    public function init()
    {
        parent::init();
        if (!\Yii::app()->user->isGuest)
            $this->assign('user', \Yii::app()->user->id);
    }

    public static function checkOwner($entity, $user)
    {
        $user = $user instanceof \User ? $user->id : (int) $user;
        if (isset($entity->author_id)) {
            return $entity->author_id == $user;
        } elseif (isset($entity->authorId)) {
            return $entity->authorId == $user;
        } elseif (isset($entity->user_id)) {
            return $entity->user_id == $user;
        } elseif (isset($entity->userId)) {
            return $entity->userId == $user;
        }
        return false;
    }

}

?>
