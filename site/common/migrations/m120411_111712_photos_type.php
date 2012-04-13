<?php

class m120411_111712_photos_type extends CDbMigration
{
    private $_table = 'club_community_content_type';

    public function up()
    {
        $this->insert($this->_table, array(
            'id' => 4,
            'name' => 'Фото-статья',
            'name_plural' => 'Фото-статьи',
            'name_accusative' => 'Фото-статью',
            'slug' => 'photos',
        ));

        $this->_table = 'club_community_photo_post';
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'location' => 'varchar(256)',
            'location_image' => 'varchar(256)',
            'location_url' => 'varchar(256)',
            'content_id' => 'int(11) unsigned NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_content', $this->_table, 'content_id', 'club_community_content', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'club_community_photos';
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'image' => 'varchar(255) NOT NULL',
            'text' => 'text',
            'post_id' => 'int(11) unsigned NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_' . $this->_table . '_post', $this->_table, 'post_id', 'club_community_photo_post', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        /*echo "m120411_111712_photos_type does not support migration down.\n";
        return false;*/
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