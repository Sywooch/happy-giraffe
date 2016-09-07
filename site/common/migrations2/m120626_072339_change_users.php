<?php

class m120626_072339_change_users extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users` ADD `remember_code` MEDIUMINT( 5 ) NOT NULL ");
        $this->execute("drop table mail__templates");
        $this->execute("CREATE TABLE IF NOT EXISTS `mail__templates` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `action` varchar(255) NOT NULL,
      `subject` varchar(100) NOT NULL,
      `body` text NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;");
        $this->execute("INSERT INTO `mail__templates` (`id`, `title`, `action`, `subject`, `body`) VALUES
        (1, 'Восстановление пароля', 'remember_password', 'Восстановление пароля', '');");
	}

	public function down()
	{
		echo "m120626_072339_change_users does not support migration down.\n";
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