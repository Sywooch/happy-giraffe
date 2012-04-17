<?php

class m120417_114147_rename_last_columns extends CDbMigration
{
    private $_table = 'reports';

    public function up()
    {
        $this->renameColumn($this->_table, 'model', 'entity');
        $this->renameColumn($this->_table, 'object_id', 'entity_id');
        $this->addForeignKey('fk_' . $this->_table . '_author', $this->_table, 'author_id', 'users', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m120417_114147_rename_last_columns does not support migration down.\n";
        return false;
    }
}