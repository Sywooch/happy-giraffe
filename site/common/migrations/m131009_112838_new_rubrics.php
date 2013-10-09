<?php

class m131009_112838_new_rubrics extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO community__rubrics (title, community_id) VALUES ('Рыбки', 39), ('Грызуны', 39), ('Птицы', 39), ('Рептилии', 39), ('Насекомые членистоногие', 39), ('Улитки', 39), ('Рассказы о наших питомцах', 39);");
	}

	public function down()
	{
		echo "m131009_112838_new_rubrics does not support migration down.\n";
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