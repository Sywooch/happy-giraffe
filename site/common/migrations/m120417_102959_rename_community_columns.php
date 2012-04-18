<?php

class m120417_102959_rename_community_columns extends CDbMigration
{
    private $_table = 'community__travels';
    public function up()
    {
        $this->renameColumn('community__communities', 'name', 'title');
        $this->renameColumn('community__contents', 'name', 'title');
        $this->renameColumn('community__content_types', 'name', 'title');
        $this->renameColumn('community__content_types', 'name_plural', 'title_plural');
        $this->renameColumn('community__content_types', 'name_accusative', 'title_accusative');
        $this->renameColumn('community__rubrics', 'name', 'title');

        $this->addForeignKey('fk_'.$this->_table.'_content', $this->_table, 'content_id', 'community__contents', 'id','CASCADE',"CASCADE");
        $this->_table = 'community__travel_images';
        $this->addForeignKey('fk_'.$this->_table.'_travel', $this->_table, 'travel_id', 'community__travels', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        echo "m120417_102959_rename_community_columns does not support migration down.\n";
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