<?php

class m121002_110151_cook_decor_indexes extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `cook__decorations` ADD INDEX (  `created` );
ALTER TABLE  `cook__decorations` ADD INDEX (  `photo_id` );

ALTER TABLE  `cook__decorations` ADD FOREIGN KEY (  `photo_id` ) REFERENCES  `happy_giraffe`.`album__photos` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `cook__decorations` DROP FOREIGN KEY  `FK_cook__decorations_cook__decorations__categories_id` ,
ADD FOREIGN KEY (  `category_id` ) REFERENCES  `happy_giraffe`.`cook__decorations__categories` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;
");
	}

	public function down()
	{
		echo "m121002_110151_cook_decor_indexes does not support migration down.\n";
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