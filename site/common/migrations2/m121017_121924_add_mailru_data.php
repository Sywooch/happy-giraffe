<?php

class m121017_121924_add_mailru_data extends CDbMigration
{
    private $_table = 'mailru__queries';

	public function up()
	{
        $this->_table = 'mailru__users';
        $this->dropTable($this->_table);

        $sql = <<<EOD
CREATE TABLE IF NOT EXISTS `mailru__users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `deti_url` varchar(255) DEFAULT NULL,
  `moi_mir_url` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `last_visit` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mailru__babies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
EOD;
        $this->execute($sql);
        $this->addForeignKey('fk_mailru__babies_parent', 'mailru__babies', 'parent_id', 'mailru__users', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
        echo "m121003_071750_statuses does not support migration down.\n";
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