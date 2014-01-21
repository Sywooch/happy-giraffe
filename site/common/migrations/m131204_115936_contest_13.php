<?php

class m131204_115936_contest_13 extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `contest__contests` (`id`, `title`, `text`, `results_text`, `rules`, `from_time`, `till_time`, `status`, `last_updated`)
VALUES
	(13, 'Моя любимая игрушка', '<p>Любимая игрушка есть у каждого счастливого ребенка. Быть может, это плюшевый мишка, которого ваш кроха заботливо кормит кашей. Или огромный самосвал, который так весело катать за собой на веревочке. А, может, это занимательный конструктор, из которого можно строить замки и дворцы.</p>\n<p>Поделитесь фотографией вашего малыша с любимой игрушкой и получите замечательные призы, которые очень понравятся вашему ребенку! </p>', '', '', '2013-12-04', '0000-00-00', 1, '2013-12-04 16:08:42');
");
	}

	public function down()
	{
		echo "m131204_115936_contest_13 does not support migration down.\n";
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