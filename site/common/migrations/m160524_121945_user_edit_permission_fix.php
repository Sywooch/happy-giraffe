<?php

/**
 * исправление ошибки проверки прав доступа редактированию профиля, можно 
 * было редактировать любой профиль
 */
class m160524_121945_user_edit_permission_fix extends CDbMigration
{

    public function up()
    {
        $this->execute('UPDATE `newauth__items` SET `bizrule` = "return $params[\'entity\']->id == \\Yii::app()->user->id;" WHERE `name` = "manageOwnProfile";');
    }

    public function down()
    {
        echo "m160524_121945_user_edit_permission_fix does not support migration down.\n";
        return false;
    }

}
