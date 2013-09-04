<?php

class m130826_111201_add_repost_type extends CDbMigration
{
    private $_table = 'community__content_types';

    public function up()
    {
        $this->insert($this->_table, array(
            'id' => 6,
            'title' => 'Репост',
            'title_plural' => 'Репосты',
            'title_accusative' => 'Репост',
            'slug' => 'repost',
        ));
    }

    public function down()
    {
        $this->delete($this->_table, 'id=6');
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