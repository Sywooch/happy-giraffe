<?php

class m120321_124416_new_authRules extends CDbMigration
{
    private $_table = 'auth_item';

    public function up()
    {
        $exist = Yii::app()->db->createCommand()
            ->select('count(name)')
            ->from($this->_table)
            ->where(' name = "removeAlbumPhoto" ')
            ->queryScalar();

        if ($exist == 0)
            $this->insert($this->_table, array(
                'name' => 'removeAlbumPhoto',
                'type' => '0',
                'description' => 'Удаление фото',
            ));
    }

    public function down()
    {
        echo "m120321_124416_new_authRules does not support migration down.\n";
        return false;
    }

    /*
     // Use safeUp/safeDown to do migration with transaction
     public function safeUp()
     {
     }

     public function safeDown()
     {
     }
     */
}