<?php

class m121115_083125_add_needlework extends CDbMigration
{
    private $_table = 'temp_keywords';
	public function up()
	{
        $this->execute("INSERT INTO `happy_giraffe_seo`.`auth__items`
        (`name`, `type`, `description`, `bizrule`, `data`) VALUES
        ('needlework-manager-panel', '2', 'Шеф-редактор рукоделия', NULL, NULL);");

        $this->addColumn($this->_table, 'section', 'tinyint(4) not null default 1');
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