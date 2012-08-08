<?php

class m120803_120059_recipeTags extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `happy_giraffe`.`cook__recipe_tags` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` VARCHAR( 255 ) NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;");
        $this->execute("CREATE TABLE `happy_giraffe`.`cook__recipe_recipes_tags` (
`recipe_id` INT( 11 ) UNSIGNED NOT NULL ,
`tag_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
");
        $this->execute("ALTER TABLE `cook__recipe_recipes_tags` ADD INDEX ( `recipe_id` ) ");
        $this->execute("ALTER TABLE `cook__recipe_recipes_tags` ADD INDEX ( `tag_id` ) ");
        $this->execute("ALTER TABLE `cook__recipe_recipes_tags` ADD FOREIGN KEY ( `recipe_id` ) REFERENCES `happy_giraffe`.`cook__recipes` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE `cook__recipe_recipes_tags` ADD FOREIGN KEY ( `tag_id` ) REFERENCES `happy_giraffe`.`cook__recipe_tags` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;");
        $this->execute("INSERT INTO `happy_giraffe`.`cook__recipe_tags` (
`id` ,
`title`
)
VALUES (
NULL , 'Новый год'
);
");
        $this->execute("INSERT INTO `happy_giraffe`.`auth__items` (
`name` ,
`type` ,
`description` ,
`bizrule` ,
`data`
)
VALUES (
'recipe_tags', '0', 'Теги к рецептам', NULL , NULL
);");
	}

	public function down()
	{
		echo "m120803_120059_recipeTags does not support migration down.\n";
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