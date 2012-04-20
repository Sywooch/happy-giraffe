<?php

class m120418_054646_rename_vaccine_columns extends CDbMigration
{
    private $_table = 'vaccine__dates_votes';

    public function up()
    {
        $this->renameColumn('vaccine__vaccines', 'name', 'title');

        $this->renameColumn('vaccine__diseases', 'name', 'title');
        $this->renameColumn('vaccine__diseases', 'name_genitive', 'title_genitive');

        $this->dropForeignKey('vaccine_date_vote_object_fk', 'vaccine__dates_votes');
        $this->renameColumn('vaccine__dates_votes', 'object_id', 'entity_id');
        $this->addForeignKey('fk_'.$this->_table.'_entity', $this->_table, 'entity_id', 'vaccine__dates', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        echo "m120418_054646_rename_vaccine_columns does not support migration down.\n";
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