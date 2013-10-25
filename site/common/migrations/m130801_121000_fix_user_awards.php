<?php

class m130801_121000_fix_user_awards extends CDbMigration
{
    private $_table = 'score__user_achievements';

	public function up()
	{
        $this->execute('ALTER TABLE  `score__user_achievements` DROP FOREIGN KEY  `score__user_achievements_user` ;
            ALTER TABLE  `score__user_achievements` DROP FOREIGN KEY  `score__user_achievements_achievement`;');
        $this->execute('ALTER TABLE score__user_achievements DROP PRIMARY KEY');
        $this->addColumn($this->_table, 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
        $this->addForeignKey('fk_'.$this->_table.'_user', $this->_table, 'user_id', 'users', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_achievement', $this->_table, 'achievement_id', 'score__achievements', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
		echo "m130801_121000_fix_user_awards does not support migration down.\n";
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