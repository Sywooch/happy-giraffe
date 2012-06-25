<?php

class m120625_094338_create_mail_templates extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE mail__templates(
          id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          title VARCHAR(255) NOT NULL,
          `action` VARCHAR(255) NOT NULL,
          body TEXT NOT NULL,
          PRIMARY KEY (id)
        )
        ENGINE = INNODB
        AUTO_INCREMENT = 1
        CHARACTER SET utf8
        COLLATE utf8_general_ci;");
	}

	public function down()
	{
		echo "m120625_094338_create_mail_templates does not support migration down.\n";
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