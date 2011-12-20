<?php

class m111219_131714_club_to_innoDb extends CDbMigration
{
    private $_table = '';

    public function up()
    {
        $this->execute('ALTER TABLE  `club_budget` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_budget_theme` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_comment` ENGINE = INNODB');

        $this->execute('ALTER TABLE  `club_contest` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_contest_map` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_contest_prize` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_contest_user` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_contest_winner` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_contest_work` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_contest_work_comment` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_photo` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_photo_comment` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_post` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `club_theme` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `comment` ENGINE = INNODB');

        $this->_table = 'club_budget';
        $this->addForeignKey($this->_table . '_theme_fk', $this->_table, 'theme_id', 'club_budget_theme', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'club_contest';
        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'contest_user_id', 'user', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'club_contest_map';
        $this->addForeignKey($this->_table . '_map_contest_fk', $this->_table, 'map_contest_id', 'club_contest', 'contest_id', 'CASCADE', "CASCADE");

        $this->_table = 'club_contest_prize';
        $this->execute('ALTER TABLE  `shop_product` ENGINE = INNODB');
        $this->addForeignKey($this->_table . '_contest_fk', $this->_table, 'prize_contest_id', 'club_contest', 'contest_id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_item_fk', $this->_table, 'prize_item_id', 'shop_product', 'product_id', 'CASCADE', "CASCADE");

        $this->_table = 'club_contest_user';
        $this->addForeignKey($this->_table . '_contest_fk', $this->_table, 'user_contest_id', 'club_contest', 'contest_id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'user_user_id', 'user', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'club_contest_winner';
        $this->addForeignKey($this->_table . '_contest_fk', $this->_table, 'winner_contest_id', 'club_contest', 'contest_id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'winner_user_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_prize_fk', $this->_table, 'winner_prize_id', 'club_contest_prize', 'prize_id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_work_fk', $this->_table, 'winner_work_id', 'club_contest_work', 'work_id', 'CASCADE', "CASCADE");

        $this->_table = 'club_contest_work';
        $this->addForeignKey($this->_table . '_contest_fk', $this->_table, 'work_contest_id', 'club_contest', 'contest_id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'work_user_id', 'user', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'club_contest_work_comment';
        $this->execute('DELETE FROM club_contest_work_comment WHERE comment_work_id NOT IN (SELECT work_id FROM club_contest_work)');
        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'comment_user_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_work_fk', $this->_table, 'comment_work_id', 'club_contest_work', 'work_id', 'CASCADE', "CASCADE");

        $this->_table = 'club_photo';
        $this->alterColumn($this->_table, 'author_id', 'int unsigned');
        $this->alterColumn($this->_table, 'contest_id', 'int unsigned');
        $this->addForeignKey($this->_table . '_contest_fk', $this->_table, 'contest_id', 'club_contest', 'contest_id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_author_fk', $this->_table, 'author_id', 'user', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'club_photo_comment';
        $this->alterColumn('club_photo_comment', 'author_id', 'int UNSIGNED');
        $this->addForeignKey($this->_table . '_author_fk', $this->_table, 'author_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_post_fk', $this->_table, 'post_id', 'club_post', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'club_post';
        $this->alterColumn($this->_table, 'author_id', 'int unsigned');
        $this->addForeignKey($this->_table . '_author_fk', $this->_table, 'author_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_theme_fk', $this->_table, 'theme_id', 'club_theme', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'comment';
        $this->addForeignKey($this->_table . '_author_fk', $this->_table, 'author_id', 'user', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {

    }

}