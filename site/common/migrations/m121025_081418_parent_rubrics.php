<?php

class m121025_081418_parent_rubrics extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `community__rubrics` ADD  `parent_id` INT( 11 ) UNSIGNED NULL");
        $this->execute("ALTER TABLE  `community__rubrics` ADD INDEX (  `parent_id` )");
        $this->execute("ALTER TABLE  `community__rubrics` ADD FOREIGN KEY (  `parent_id` ) REFERENCES  `happy_giraffe`.`community__rubrics` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;");
        $this->execute("INSERT INTO `happy_giraffe`.`community__rubrics` (`id`, `title`, `community_id`, `user_id`, `parent_id`) VALUES (NULL, 'Гладью', '24', NULL, '193'), (NULL, 'Крестиком', '24', NULL, '193'), (NULL, 'Лентами', '24', NULL, '193'), (NULL, 'Бисером', '24', NULL, '193');");
        $this->execute("INSERT INTO `happy_giraffe`.`community__rubrics` (`id`, `title`, `community_id`, `user_id`, `parent_id`) VALUES (NULL, 'Для мужчин', '24', NULL, '194'), (NULL, 'Для женщин', '24', NULL, '194');");
        $this->execute("INSERT INTO `happy_giraffe`.`community__rubrics` (`id`, `title`, `community_id`, `user_id`, `parent_id`) VALUES (NULL, 'Спицами', '24', NULL, '195'), (NULL, 'Крючком', '24', NULL, '195');");
        $this->execute("INSERT INTO `happy_giraffe`.`community__rubrics` (`id`, `title`, `community_id`, `user_id`, `parent_id`) VALUES (NULL, 'Мальчики', '25', NULL, '205'), (NULL, 'Девочки', '25', NULL, '205');");

        $this->execute("INSERT INTO `happy_giraffe`.`community__rubrics` (`id`, `title`, `community_id`, `user_id`, `parent_id`) VALUES (NULL, 'Роспись', '25', NULL, NULL);");
        $lastId = PDO::lastInsertId();
        $this->execute("INSERT INTO `happy_giraffe`.`community__rubrics` (`id`, `title`, `community_id`, `user_id`, `parent_id`) VALUES (NULL, 'По дереву', '25', NULL, $lastId), (NULL, 'По ткани', '25', NULL, $lastId), (NULL, 'По стеклу', '25', NULL, $lastId), (NULL, 'По керамике', '25', NULL, $lastId);");

        $this->execute("INSERT INTO `happy_giraffe`.`community__rubrics` (`id`, `title`, `community_id`, `user_id`, `parent_id`) VALUES (NULL, 'Плетение', '25', NULL, NULL);");
        $lastId = PDO::lastInsertId();
        $this->execute("INSERT INTO `happy_giraffe`.`community__rubrics` (`id`, `title`, `community_id`, `user_id`, `parent_id`) VALUES (NULL, 'Из лозы', '25', NULL, $lastId), (NULL, 'Из соломы', '25', NULL, $lastId), (NULL, 'Из газет', '25', NULL, $lastId), (NULL, 'Из лент', '25', NULL, $lastId);");
	}

	public function down()
	{
		echo "m121025_081418_parent_rubrics does not support migration down.\n";
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