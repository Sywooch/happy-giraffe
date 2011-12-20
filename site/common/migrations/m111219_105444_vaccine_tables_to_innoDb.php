<?php

class m111219_105444_vaccine_tables_to_innoDb extends CDbMigration
{
    private $_table = 'vaccine_date';

    public function up()
    {
        $this->execute('ALTER TABLE  `vaccine` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `vaccine_date` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `vaccine_date_disease` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `vaccine_disease` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `vaccine_user_vote` ENGINE = INNODB');

        $this->addForeignKey($this->_table . '_vaccine_fk', $this->_table, 'vaccine_id', 'vaccine', 'id', 'CASCADE', "CASCADE");
        $this->execute('ALTER TABLE `vaccine_date_disease` DROP PRIMARY KEY,
           ADD PRIMARY KEY( `vaccine_date_id`,`vaccine_disease_id`);');
        $this->addForeignKey('vaccine_date_fk', 'vaccine_date_disease', 'vaccine_date_id', $this->_table, 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('vaccine_disease_fk', 'vaccine_date_disease', 'vaccine_disease_id', 'vaccine_disease', 'id', 'CASCADE', "CASCADE");

        $this->truncateTable('vaccine_user_vote');
        $this->execute('ALTER TABLE  `user` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `user_baby` ENGINE = INNODB');
        $this->alterColumn('user', 'id', 'int UNSIGNED');
        $this->alterColumn('vaccine_user_vote', 'user_id', 'int UNSIGNED');
        $this->addForeignKey('vaccine_user_vote_user_fk', 'vaccine_user_vote', 'user_id', 'user', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('vaccine_user_vote_baby_fk', 'vaccine_user_vote', 'baby_id', 'user_baby', 'id', 'CASCADE',"CASCADE");
        $this->addForeignKey('vaccine_user_vote_vaccine_date_fk', 'vaccine_user_vote', 'vaccine_date_id', 'vaccine_date', 'id', 'CASCADE',"CASCADE");
    }

    public function down()
    {

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