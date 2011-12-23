<?php

class m111220_112652_name_module extends CDbMigration
{
    private $_table = 'name';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'id' => 'int(10) UNSIGNED NOT NULL AUTO_INCREMENT',
                'name' => 'varchar(30) NOT NULL',
                'gender' => 'int(1) not null',
                'translate' => 'varchar(512)',
                'origin' => 'varchar(2048)',
                'name_group_id' => 'int unsigned',
                'options' => 'varchar(512)',
                'sweet' => 'varchar(512)',
                'middle_names' => 'varchar(1024)',
                'likes' => 'int',
                'PRIMARY KEY(id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->createTable('name_group',
            array(
                'id' => 'int(10) UNSIGNED NOT NULL AUTO_INCREMENT',
                'name' => 'varchar(64) NOT NULL',
                'PRIMARY KEY(id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table . '_name_group_fk', $this->_table, 'name_group_id', 'name_group', 'id', 'CASCADE', "CASCADE");
        $this->insert('name_group', array('name' => 'славяское'));
        $this->insert('name_group', array('name' => 'греческое'));

        $this->insert('name', array(
            'name' => 'Александр',
            'translate' => 'защитник',
            'origin' => 'отслова защита',
            'name_group_id' => '1',
            'options' => 'Саша, Саня',
            'sweet' => 'Сашуля',
            'middle_names' => 'Александрович',
            'likes' => '0',
            'gender'=>'1',
        ));

        $this->insert('name', array(
            'name' => 'Александр',
            'translate' => 'защитник',
            'origin' => 'отслова защита',
            'name_group_id' => '1',
            'options' => 'Саша, Саня',
            'sweet' => 'Сашуля',
            'middle_names' => 'Александрович',
            'likes' => '0',
            'gender'=>'1',
        ));

        $this->insert('name', array(
            'name' => 'Александр',
            'translate' => 'защитник',
            'origin' => 'отслова защита',
            'name_group_id' => '1',
            'options' => 'Саша, Саня',
            'sweet' => 'Сашуля',
            'middle_names' => 'Александрович',
            'likes' => '0',
            'gender'=>'1',
        ));

        $this->insert('name', array(
            'name' => 'Софья',
            'translate' => 'защитник',
            'origin' => 'отслова защита',
            'name_group_id' => '1',
            'options' => 'Саша, Саня',
            'sweet' => 'Сашуля',
            'middle_names' => 'Александрович',
            'likes' => '0',
            'gender'=>'2',
        ));

        $this->insert('name', array(
            'name' => 'Софья',
            'translate' => 'защитник',
            'origin' => 'отслова защита',
            'name_group_id' => '1',
            'options' => 'Саша, Саня',
            'sweet' => 'Сашуля',
            'middle_names' => 'Александрович',
            'likes' => '0',
            'gender'=>'2',
        ));

        $this->insert('name', array(
            'name' => 'Софья',
            'translate' => 'защитник',
            'origin' => 'отслова защита',
            'name_group_id' => '1',
            'options' => 'Саша, Саня',
            'sweet' => 'Сашуля',
            'middle_names' => 'Александрович',
            'likes' => '0',
            'gender'=>'2',
        ));

        $this->_table = 'name_famous';
        $this->createTable($this->_table,
            array(
                'id' => 'int(10) UNSIGNED NOT NULL AUTO_INCREMENT',
                'name_id' => 'int unsigned not null',
                'middle_name' => 'varchar(50)',
                'last_name' => 'varchar(50) NOT NULL',
                'description' => 'varchar(256) NOT NULL',
                'photo' => 'varchar(256)',
                'PRIMARY KEY(id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table . '_name_fk', $this->_table, 'name_id', 'name', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'name_likes';
        $this->createTable($this->_table,
            array(
                'name_id' => 'int unsigned not null',
                'user_id' => 'int unsigned not null',
                'PRIMARY KEY (name_id, user_id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table . '_name_fk', $this->_table, 'name_id', 'name', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'user_id', 'user', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'name_saint_date';
        $this->createTable($this->_table,
            array(
                'id' => 'int(10) UNSIGNED NOT NULL AUTO_INCREMENT',
                'name_id' => 'int unsigned not null',
                'day' => 'int unsigned not null',
                'month' => 'int unsigned not null',
                'PRIMARY KEY (id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table . '_name_fk', $this->_table, 'name_id', 'name', 'id', 'CASCADE', "CASCADE");
        $this->createIndex('date_i', $this->_table , 'day, month');
    }

    public function down()
    {
        $this->_table = 'name_saint_date';
        $this->dropForeignKey($this->_table . '_name_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'name_likes';
        $this->dropForeignKey($this->_table . '_name_fk', $this->_table);
        $this->dropForeignKey($this->_table . '_user_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'name_famous';
        $this->dropForeignKey($this->_table . '_name_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'name';
        $this->dropForeignKey($this->_table . '_name_group_fk', $this->_table);
        $this->dropTable($this->_table);
        $this->dropTable('name_group');
    }

}