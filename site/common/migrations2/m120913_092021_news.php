<?php

class m120913_092021_news extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO  `happy_giraffe`.`community__communities` (
`id` ,
`title` ,
`pic` ,
`position` ,
`css_class`
)
VALUES (
NULL ,  'Новости с Весёлым Жирафом',  '',  '0', NULL
);

INSERT INTO  `happy_giraffe`.`community__rubrics` (
`id` ,
`title` ,
`community_id` ,
`user_id`
)
VALUES (
NULL ,  'Беременность и роды',  '36', NULL
), (
NULL ,  'Дети',  '36', NULL
), (
NULL ,  'Свадьба и отношения',  '36', NULL
), (
NULL ,  'Здоровье',  '36', NULL
), (
NULL ,  'Кулинария',  '36', NULL
), (
NULL ,  'Образование',  '36', NULL
), (
NULL ,  'Недвижимость',  '36', NULL
), (
NULL ,  'Отдых',  '36', NULL
);

INSERT INTO `happy_giraffe`.`auth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('news', '0', 'Новости с Весёлым Жирафом', NULL, NULL);");
	}

	public function down()
	{
		echo "m120913_092021_news does not support migration down.\n";
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