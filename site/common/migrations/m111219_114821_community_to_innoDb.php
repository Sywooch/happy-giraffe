<?php

class m111219_114821_community_to_innoDb extends CDbMigration
{
    private $_table = 'club_community';

    public function up()
    {
        $this->execute('ALTER TABLE  `club_community` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_community_comment` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_community_content` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_community_content_type` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_community_post` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_community_rubric` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_community_video` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `user_via_community` ENGINE = INNODB');

        $this->_table = 'club_community_comment';
        $this->addForeignKey($this->_table . '_author_fk', $this->_table, 'author_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_content_fk', $this->_table, 'content_id', 'club_community_content', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'club_community_content';
        $this->addForeignKey($this->_table . '_author_fk', $this->_table, 'author_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_rubric_fk', $this->_table, 'rubric_id', 'club_community_rubric', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_type_fk', $this->_table, 'type_id', 'club_community_content_type', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'club_community_post';
        $this->execute('DELETE FROM club_community_post WHERE content_id NOT IN (SELECT id FROM club_community_content)');
        $this->addForeignKey($this->_table . '_content_fk', $this->_table, 'content_id', 'club_community_content', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'club_community_rubric';
        $this->addForeignKey($this->_table . '_community_fk', $this->_table, 'community_id', 'club_community', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'club_community_video';
        $this->execute('DELETE FROM club_community_video WHERE content_id NOT IN (SELECT id FROM club_community_content)');
        $this->addForeignKey($this->_table . '_content_fk', $this->_table, 'content_id', 'club_community_content', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'user_via_community';
        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'user_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_community_fk', $this->_table, 'community_id', 'club_community', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {

    }

}