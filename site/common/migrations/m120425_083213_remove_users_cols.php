<?php

class m120425_083213_remove_users_cols extends CDbMigration
{
    private $_table = 'users';

    public function up()
    {
        $this->dropColumn($this->_table, 'external_id');
        $this->dropColumn($this->_table, 'vk_id');
        $this->dropColumn($this->_table, 'nick');
        $this->dropColumn($this->_table, 'link');
        $this->dropColumn($this->_table, 'mail_id');

        $this->renameColumn($this->_table, 'avatar', 'avatar_id');
        $this->alterColumn($this->_table, 'avatar_id', 'int(11) unsigned');

        $this->addForeignKey('fk_' . $this->_table . '_avatar', $this->_table, 'avatar_id', 'album__photos', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        echo "m120425_083213_remove_users_cols does not support migration down.\n";
        return false;
    }
}