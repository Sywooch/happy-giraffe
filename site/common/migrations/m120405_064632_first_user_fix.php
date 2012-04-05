<?php

class m120405_064632_first_user_fix extends CDbMigration
{
	public function up()
	{
        $sql = <<<EOD
delete from `auth_assignment` WHERE `userid` = 1;
update `recipeBook_recipe` SET author_id = 10000 WHERE author_id = 1;
update `club_community_content` SET author_id = 10000 WHERE author_id = 1;
update `comment` SET author_id = 10000 WHERE author_id = 1 AND entity != 'User';
delete from user_community WHERE `userid` = 1;
delete from user_scores WHERE `userid` = 1;
EOD;
        $this->execute($sql);
	}

	public function down()
	{
//		echo "m120405_064632_first_user_fix does not support migration down.\n";
//		return false;
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