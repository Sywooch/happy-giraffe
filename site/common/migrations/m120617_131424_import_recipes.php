<?php

class m120617_131424_import_recipes extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `cook__recipes` ADD `content_id` INT( 11 ) UNSIGNED NULL ;
ALTER TABLE `cook__recipes` ADD INDEX ( `content_id` ) ;
ALTER TABLE `cook__recipes` ADD FOREIGN KEY ( `content_id` ) REFERENCES `happy_giraffe`.`community__contents` (
`id`
) ON DELETE SET NULL ON UPDATE CASCADE ;

INSERT INTO `happy_giraffe`.`auth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('importCookRecipes', 0, 'Импорт рецептов', NULL, NULL);");
	}

	public function down()
	{
		echo "m120617_131424_import_recipes does not support migration down.\n";
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