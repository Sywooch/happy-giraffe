<?php

class m130205_101630_add_valentine extends CDbMigration
{
    private $_table = 'auth__items';

    public function up()
    {
        $this->insert($this->_table, array(
            'name' => 'valentines_day',
            'type' => 0,
            'description' => 'Редактирование сервиса на День Святого Валентина',
        ));

        $this->_table = 'valentine__sms';
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(100) NOT NULL',
            'text' => 'text',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $sql = <<<EOD
INSERT INTO `happy_giraffe`.`community__communities` (`id`, `title`, `short_title`, `pic`, `position`, `css_class`) VALUES (NULL, 'День Святого Валентина', '', '', '0', NULL);
INSERT INTO `happy_giraffe`.`community__rubrics` (`id`, `title`, `community_id`, `user_id`, `parent_id`) VALUES (NULL, 'День Святого Валентина', '37', NULL, NULL);
EOD;
        $this->execute($sql);
    }

    public function down()
    {
        echo "m130205_101630_add_valentine does not support migration down.\n";
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