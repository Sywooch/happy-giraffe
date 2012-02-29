<?php

class m120228_104521_vaccine_dizz_link extends CDbMigration
{
    private $_table = 'vaccine_disease';

    public function up()
    {
        $this->addColumn($this->_table, 'disease_id', 'int(11) UNSIGNED');
        $this->addForeignKey($this->_table.'_disease_fk', $this->_table, 'disease_id', 'recipeBook_disease', 'id',
            'CASCADE',"CASCADE");
    }

    public function down()
    {
        $this->dropForeignKey($this->_table . '_disease_fk', $this->_table);
        $this->dropColumn($this->_table, 'disease_id');
    }
}