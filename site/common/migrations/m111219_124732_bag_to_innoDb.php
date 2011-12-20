<?php

class m111219_124732_bag_to_innoDb extends CDbMigration
{
    private $_table = 'bag_item';

    public function up()
    {
        $this->execute('ALTER TABLE  `bag_category` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `bag_item` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `bag_offer` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `bag_user_vote` ENGINE = INNODB');

        $this->addForeignKey($this->_table . '_category_fk', $this->_table, 'category_id', 'bag_category', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'bag_offer';
        $this->addForeignKey($this->_table . '_item_fk', $this->_table, 'item_id', 'bag_item', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'user_id', 'user', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'bag_user_vote';
        $this->addForeignKey($this->_table . '_offer_fk', $this->_table, 'offer_id', 'bag_offer', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'user_id', 'user', 'id', 'CASCADE', "CASCADE");
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