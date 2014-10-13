<?php

namespace site\frontend\modules\editorialDepartment\components;

/**
 * Description of UsersControl
 *
 * @author Кирилл
 */
class UsersControl extends \CComponent
{

    public static function getUsersList()
    {
        return array(\Yii::app()->user->id);
    }

}

?>
