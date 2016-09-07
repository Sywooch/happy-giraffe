<?php

class m160719_115734_add_id_field_to_answer_vote extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `qa__answers_votes` DROP FOREIGN KEY `qa__answers_votes_ibfk_1`;");

		$this->execute("ALTER TABLE `qa__answers_votes`
ADD COLUMN `id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT FIRST ,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`id`);");

		$this->createIndex('answer_idx', 'qa__answers_votes', 'answerId');;
	}

	public function down()
	{
		return false;
	}
}