<?php

class m120217_073933_add_auth extends CDbMigration
{
    private $_table = 'auth_item';

	public function up()
	{
        $this->createTable($this->_table,
           array(
               'name'=>'varchar(64) NOT NULL',
               'type'=>'int(11) NOT NULL',
               'description'=>'text',
               'bizrule'=>'text',
               'data'=>'text',
               'PRIMARY KEY (`name`)',
           ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'auth_item_child';
        $this->createTable($this->_table,
            array(
                'parent'=>'varchar(64) NOT NULL',
                'child'=>'varchar(64) NOT NULL',
                'PRIMARY KEY (`parent`,`child`)',
                'KEY `child` (`child`)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey($this->_table.'_parent_fk', $this->_table, 'parent', 'auth_item', 'name','CASCADE',"CASCADE");
        $this->addForeignKey($this->_table.'_child_fk', $this->_table, 'child', 'auth_item', 'name','CASCADE',"CASCADE");

        $this->_table = 'auth_assignment';
        $this->createTable($this->_table,
            array(
                'itemname'=>'varchar(64) NOT NULL',
                'userid'=>'varchar(64) NOT NULL',
                'bizrule'=>'text',
                'data'=>'text',
                'PRIMARY KEY (`itemname`,`userid`)',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table.'_itemname_fk', $this->_table, 'itemname', 'auth_item', 'name','CASCADE',"CASCADE");

        $this->execute("
SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";

INSERT INTO `auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('moderator', 2, 'Основной модератор', NULL, NULL),
('категории', 0, 'Управление категориями', NULL, NULL),
('магазин', 1, 'управление элементами магазина', NULL, NULL),
('скидки', 0, 'Управление скидками', NULL, NULL),
('товары', 0, 'Управление товарами', NULL, NULL);


INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('moderator', 'категории'),
('магазин', 'категории'),
('moderator', 'магазин'),
('магазин', 'скидки'),
('магазин', 'товары');

");
        $this->_table = 'user';
        $this->dropColumn($this->_table, 'role');
	}

	public function down()
	{
        $this->_table = 'auth_assignment';
        $this->dropTable($this->_table);
        $this->_table = 'auth_item_child';
        $this->dropTable($this->_table);
        $this->_table = 'auth_item';
        $this->dropTable($this->_table);

        $this->_table = 'user';
        $this->addColumn($this->_table, 'role', 'varchar(256)');
	}
}