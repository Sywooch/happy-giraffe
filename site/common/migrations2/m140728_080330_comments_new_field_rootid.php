<?php

class m140728_080330_comments_new_field_rootid extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE `comments` ADD COLUMN `root_id` INT(11) UNSIGNED NULL DEFAULT NULL  AFTER `removed` , 
            ADD CONSTRAINT `fk_comments_comments1`
            FOREIGN KEY (`root_id` )
            REFERENCES `comments` (`id` )
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
          , ADD INDEX `fk_comments_comments1` (`root_id` ASC) ');
        $this->execute('UPDATE `comments` SET `root_id`=`id` WHERE `response_id` IS NULL');
        $db = $this->dbConnection;
        while($db->createCommand('SELECT COUNT(id) FROM `comments` WHERE root_id IS NULL')->queryScalar())
        {
            $this->execute('UPDATE `comments`, (SELECT `id`, `root_id` FROM `comments`) as tmp SET `comments`.`root_id` = tmp.root_id WHERE `comments`.`response_id` = tmp.`id`');
        }
	}

	public function down()
	{
		echo "m140728_080330_comments_new_field_rootid does not support migration down.\n";
		return false;
	}
}